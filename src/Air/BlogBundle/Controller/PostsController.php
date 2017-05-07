<?php

namespace Air\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Air\BlogBundle\Entity\Comment;
use Air\BlogBundle\Form\Type\CommentType;

class PostsController extends Controller
{
    protected $itemsLimit = 3;
    
    /**
     * @Route(
     *      "/{page}",
     *      name = "blog_index",
     *      defaults = {"page" = 1},
     *      requirements = {"page" = "\d+"}
     * )
     * 
     * @Template("AirBlogBundle:Posts:postsList.html.twig")
     */
    public function indexAction($page)
    {
        $pagination = $this->getPaginatedPosts(array(
            'status' => 'published',
            'orderBy' => 'p.publishedDate',
            'orderDir' => 'DESC'
        ), $page);
        
        return array(
            'pagination' => $pagination,
            'listTitle' => 'Najnowsze wpisy'
        );
    }
    
    
    /**
     * @Route(
     *      "/search/{page}",
     *      name = "blog_search",
     *      defaults = {"page" = 1},
     *      requirements = {"page" = "\d+"}
     * )
     * 
     * @Template("AirBlogBundle:Posts:postsList.html.twig")
     */
    public function searchAction(\Symfony\Component\HttpFoundation\Request $request, $page)
    {
        $searchParam = $request->query->get('search');
        
        $pagination = $this->getPaginatedPosts(array(
            'status' => 'published',
            'orderBy' => 'p.publishedDate',
            'orderDir' => 'DESC',
            'search' => $searchParam
        ), $page);
        
        return array(
            'pagination' => $pagination,
            'listTitle' => sprintf('Wyniki wyszukiwania frazy "%s"', $searchParam),
            'searchParam' => $searchParam
        );
    }
    
    
    /**
     * @Route(
     *      "/{slug}",
     *      name = "blog_post"
     * )
     * 
     * @Template()
     */
    public function postAction(Request $request, $slug)
    {
        $PostRepo = $this->getDoctrine()->getRepository('AirBlogBundle:Post');
        
        $Post = $PostRepo->getPublishedPost($slug);
        
        if(null === $Post){
            throw $this->createNotFoundException('Post nie został odnaleziony.');
        }
        
        if(null !== $this->getUser()){
            
            $Comment = new Comment();
            $Comment->setAuthor($this->getUser())
                    ->setPost($Post);
            
            $commentForm = $this->createForm(new CommentType(), $Comment);
            
            if($request->isMethod('POST')){
                $commentForm->handleRequest($request);

                if($commentForm->isValid()){
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($Comment);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('success', 'Komentarz dodany!');
                    
                    $redirectUrl = $this->generateUrl('blog_post', array(
                        'slug' => $Post->getSlug()
                    ));

                    return $this->redirect($redirectUrl);
                }
            }
        }
        
        if($this->get('security.context')->isGranted('ROLE_ADMIN')){
            $csrfProvider = $this->get('form.csrf_provider');
        }
        
        return array(
            'post' => $Post,
            'commentForm' => isset($commentForm) ? $commentForm->createView() : null,
            'csrfProvider' => isset($csrfProvider) ? $csrfProvider : null,
            'tokenName' => 'delCom%d'
        );
    }
    
    /**
     * @Route(
     *      "/post/comment/delete/{commentId}/{token}",
     *      name = "blog_deleteComment"
     * )
     */
    public function deleteCommentAction($commentId, $token) {
        
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')){
            throw $this->createAccessDeniedException('Nie masz uprawnień do tego zadania!');
        }
        
        $validToken = sprintf('delCom%d', $commentId);
        if(!$this->get('form.csrf_provider')->isCsrfTokenValid($validToken, $token)){
            throw $this->createAccessDeniedException('Błędy token akcji.');
        }
        
        $Comment = $this->getDoctrine()
                ->getRepository('AirBlogBundle:Comment')
                ->find($commentId);
        
        if(null == $Comment){
            throw $this->createNotFoundException('Nie znaleziono takiego komentarza');
        }
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($Comment);
        $em->flush();
        
        return new \Symfony\Component\HttpFoundation\JsonResponse(array(
            'status' => 'ok',
            'message' => 'Wiadomość została usunięta'
        ));
    }
    
    
    /**
     * @Route(
     *      "/category/{slug}/{page}",
     *      name = "blog_category",
     *      defaults = {"page" = 1},
     *      requirements = {"page" = "\d+"}
     * )
     * 
     * @Template("AirBlogBundle:Posts:postsList.html.twig")
     */
    public function categoryAction($slug, $page)
    {
        $pagination = $this->getPaginatedPosts(array(
            'status' => 'published',
            'orderBy' => 'p.publishedDate',
            'orderDir' => 'DESC',
            'categorySlug' => $slug
        ), $page);
        
        $CategoryRepo = $this->getDoctrine()->getRepository('AirBlogBundle:Category');
        $Category = $CategoryRepo->findOneBySlug($slug);
        
        return array(
            'pagination' => $pagination,
            'listTitle' => sprintf('Wpisy w kategorii "%s"', $Category->getName())
        );
    }
    
    
    /**
     * @Route(
     *      "/tag/{slug}/{page}",
     *      name = "blog_tag",
     *      defaults = {"page" = 1},
     *      requirements = {"page" = "\d+"}
     * )
     * 
     * @Template("AirBlogBundle:Posts:postsList.html.twig")
     */
    public function tagAction($slug, $page)
    {
        
        $TagRepo = $this->getDoctrine()->getRepository('AirBlogBundle:Tag');
        $Tag = $TagRepo->findOneBySlug($slug);
        
        $pagination = $this->getPaginatedPosts(array(
            'status' => 'published',
            'orderBy' => 'p.publishedDate',
            'orderDir' => 'DESC',
            'tagSlug' => $slug
        ), $page);
        
        return array(
            'pagination' => $pagination,
            'listTitle' => sprintf('Wpisy z tagiem "%s"', $Tag->getName())
        );
    }
    
    
    protected function getPaginatedPosts(array $params = array(), $page){
        $PostRepo = $this->getDoctrine()->getRepository('AirBlogBundle:Post');
        $qb = $PostRepo->getQueryBuilder($params);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $this->itemsLimit);
        
        return $pagination;
    }
}
