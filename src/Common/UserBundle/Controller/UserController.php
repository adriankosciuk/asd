<?php

namespace Common\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Common\UserBundle\Form\Type\AccountSettingsType;
use Common\UserBundle\Form\Type\ChangePasswordType;

use Common\UserBundle\Exception\UserException;


class UserController extends Controller
{
    
    /**
     * @Route(
     *      "/account-settings",
     *      name = "user_accountSettings"
     * )
     * 
     * @Template()
     */
    public function accountSettingsAction(Request $Request)
    {        
        $User = $this->getUser();
        
        
        // Account Settings Form
        $accountSettingsForm = $this->createForm(new AccountSettingsType(), $User);
        
        if($Request->isMethod('POST') && $Request->request->has('accountSettings')){
            $accountSettingsForm->handleRequest($Request);
            
            if($accountSettingsForm->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->persist($User);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('success', 'Twoje dane zostały zmienione!');
                return $this->redirect($this->generateUrl('user_accountSettings'));
            }else{
                $this->get('session')->getFlashBag()->add('error', 'Popraw błędy formularza!');
            }
        }
        
        
        // Change Password
        $changePasswdForm = $this->createForm(new ChangePasswordType(), $User);
        
        if($Request->isMethod('POST') && $Request->request->has('changePassword')){
            $changePasswdForm->handleRequest($Request);
            
            if($changePasswdForm->isValid()){
                
                try {
                    $userManager = $this->get('user_manager');
                    $userManager->changePassword($User);

                    $this->get('session')->getFlashBag()->add('success', 'Twoje hasło zostało zmienione!');
                    return $this->redirect($this->generateUrl('user_accountSettings'));
                    
                } catch (UserException $ex) {
                    $this->get('session')->getFlashBag()->add('error', $ex->getMessage());
                }
                
            }else{
                $this->get('session')->getFlashBag()->add('error', 'Popraw błędy formularza2!');
            }
        }
        
        
        return array(
            'user' => $User,
            'accountSettingsForm' => $accountSettingsForm->createView(),
            'changePasswdForm' => $changePasswdForm->createView()
        );
    }
    
}
