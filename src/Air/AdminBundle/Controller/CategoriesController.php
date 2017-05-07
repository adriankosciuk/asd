<?php

namespace Air\AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Air\BlogBundle\Entity\Category;
use Air\AdminBundle\Form\Type\TaxonomyType;
use Air\AdminBundle\Form\Type\CategoryDeleteType;

class CategoriesController extends Controller
{    

    
    /**
     * @Route(
     *      "/list/{page}", 
     *      name="admin_categoriesList",
     *      defaults={"page"=1}
     * )
     * 
     * @Template()
     */
    public function indexAction($page) {
        
        $CategoryRepository = $this->getDoctrine()->getRepository('AirBlogBundle:Category');
        
        $qb = $CategoryRepository->getQueryBuilder();
        
        $limit = $this->container->getParameter('admin.pagination_limit');
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $limit);
        
        
        return array(
            'currPage' => 'taxonomies',
            'pagination' => $pagination
        );
    }
    
    
    /**
     * @Route(
     *      "/form/{id}", 
     *      name="admin_categoryForm",
     *      requirements={"id"="\d+"},
     *      defaults={"id"=NULL}
     * )
     * 
     * @Template()
     */
    public function formAction(Request $Request, Category $Category = NULL) {
        
        if(NULL === $Category){
            $Category = new Category();
            $newCategory = TRUE;
        }
        
        $form = $this->createForm(new TaxonomyType(), $Category);
             
        $form->handleRequest($Request);
        
        if($form->isValid()){
                
            $em = $this->getDoctrine()->getManager();
            $em->persist($Category);
            $em->flush();

            $message = (isset($newCategory)) ? 'Poprawnie dodano nową kategorię!': 'Poprawiono dane kategorii';
            $this->get('session')->getFlashBag()->add('success', $message);

            return $this->redirect($this->generateUrl('admin_categoryForm', array(
                'id' => $Category->getId()
            )));
        }
        
        return array(
            'currPage' => 'taxonomies',
            'form' => $form->createView(),
            'category' => $Category
        );
    }
    
    
    /**
     * @Route(
     *      "/delete/{id}", 
     *      name="admin_categoryDelete"
     * )
     * 
     * @Template()
     */
    public function deleteAction(Request $Request, Category $Category) {
        
        $form = $this->createForm(new CategoryDeleteType($Category));
        
        $form->handleRequest($Request);
        
        if($form->isValid()){
            
            $chosen = false;
            
            if(true === $form->get('setNull')->getData()){
                $newCategoryId = null;
                $chosen = true;
            }else if(null !== ($NewCategory = $form->get('newCategory')->getData())){
                $newCategoryId = $NewCategory->getId();
                $chosen = true;
            }
            
            if($chosen){
                
                $PostRepo = $this->getDoctrine()->getRepository('AirBlogBundle:Post');
                $modifiedPosts = $PostRepo->moveToCategory($Category->getId(), $newCategoryId);
                
                $em = $this->getDoctrine()->getManager();
                $em->remove($Category);
                $em->flush();
                
                $Request->getSession()
                        ->getFlashBag()
                        ->add('success', sprintf('Kategoria została usunięta. %d postów zostało zmodyfikowanych.', $modifiedPosts));
                
                return $this->redirect($this->generateUrl('admin_categoriesList'));
                
            }else{
                $Request->getSession()
                        ->getFlashBag()
                        ->add('error', 'Musisz wybrać nowa kategorię lub zaznaczyć checkbox!');
            }
            
        }          
        
        return array(
            'currPage' => 'taxonomies',
            'category' => $Category,
            'form' => $form->createView()
        );
    }
}
