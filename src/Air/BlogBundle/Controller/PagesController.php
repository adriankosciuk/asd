<?php

namespace Air\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Air\BlogBundle\Form\Type\ContactType;

class PagesController extends Controller
{    
    
    /**
     * @Route(
     *      "/contact",
     *      name = "blog_contact"
     * )
     * 
     * @Template()
     */
    public function contactAction(Request $request)
    {
        
        $form = $this->createForm(new ContactType());
        
        if(null !== $this->getUser()){
            $User = $this->getUser();
            
            $form->setData(array(
                'name' => $User->getUsername(),
                'email' => $User->getEmail()
            ));
        }
        
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            
            if($form->isValid()){
                $sendToEmail = $this->container->getParameter('contact_send_to');
                $sendFromEmail = $this->container->getParameter('mailer_user');
                $emailBody = $this->renderView('AirBlogBundle:Email:contact.html.twig', array(
                    'name' => $form->get('name')->getData(),
                    'email' => $form->get('email')->getData(),
                    'message' => $form->get('message')->getData()
                ));
                
                $message = \Swift_Message::newInstance()
                        ->setSubject('[AirBlog] Kontakt')
                        ->setTo($sendToEmail)
                        ->setFrom($sendFromEmail, 'AirBlog')
                        ->setBody($emailBody, 'text/html');
                
                $this->get('mailer')->send($message);
                
                $this->get('session')->getFlashBag()->add('success', 'Twoja wiadomość została wysłana!');
                
                return $this->redirect($this->generateUrl('blog_contact'));
            }
        }
        
        return array(
            'form' => $form->createView()
        );
    }
    
}
