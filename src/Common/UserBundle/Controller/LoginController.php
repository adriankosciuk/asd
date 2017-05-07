<?php

namespace Common\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;
use Common\UserBundle\Exception\UserException;
use Common\UserBundle\Entity\User;
use Common\UserBundle\Form\Type\LoginType;
use Common\UserBundle\Form\Type\RememberPasswordType;
use Common\UserBundle\Form\Type\RegisterUserType;


class LoginController extends Controller
{
    /**
     * @Route(
     *      "/login",
     *      name = "blog_login"
     * )
     * 
     * @Template()
     */
    public function loginAction(Request $Request)
    {
        $Session = $this->get('session');
        
        // Login Form
        if($Request->attributes->has(SecurityContextInterface::AUTHENTICATION_ERROR)){
            $loginError = $Request->attributes->get(SecurityContextInterface::AUTHENTICATION_ERROR);
        }else{
            $loginError = $Session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
        }
        
        if(isset($loginError)){
            $this->get('session')->getFlashBag()->add('error', $loginError->getMessage());
        }
        
        $loginForm = $this->createForm(new LoginType(), array(
            'username' => $Session->get(SecurityContextInterface::LAST_USERNAME)
        ));
        
        
        // Remember Password Form
        $rememberPasswdForm = $this->createForm(new RememberPasswordType());
        
        if($Request->isMethod('POST')){
            $rememberPasswdForm->handleRequest($Request);
            
            if($rememberPasswdForm->isValid()){
                try {
                    
                    $userEmail = $rememberPasswdForm->get('email')->getData();
                
                    $userManager = $this->get('user_manager');
                    $userManager->sendResetPasswordLink($userEmail);
                    
                    $this->get('session')->getFlashBag()->add('success', 'Instrukcje resetowania hasła zostały wysłane na adres e-mail.');
                    return $this->redirect($this->generateUrl('blog_login'));
                    
                } catch (UserException $exc) {
                    $error = new FormError($exc->getMessage());
                    $rememberPasswdForm->get('email')->addError($error);
                }

                
            }
        }
        
        
        // Register User Form
        $User = new User();
        $registerUserForm = $this->createForm(new RegisterUserType(), $User);
        
        if($Request->isMethod('POST')){
            $registerUserForm->handleRequest($Request);
            
            if($registerUserForm->isValid()){
                
                try{
                    
                    $userManager = $this->get('user_manager');
                    $userManager->registerUser($User);
                    
                    $this->get('session')->getFlashBag()->add('success', 'Konto zostało utworzone. Na Twoją skrzynkę pocztową została wysłana wiadomość aktywacyjna.');
                    
                    return $this->redirect($this->generateUrl('blog_login'));
                    
                } catch (UserException $ex) {
                    $this->get('session')->getFlashBag()->add('error', $ex->getMessage());
                }
                
            }
        }
        
        
        return array(
            'loginForm' => $loginForm->createView(),
            'rememberPasswdForm' => $rememberPasswdForm->createView(),
            'registerUserForm' => $registerUserForm->createView()
        );
    }
    
    
    /**
     * @Route(
     *      "/reset-password/{actionToken}",
     *      name = "user_resetPassword"
     * )
     */
    public function resetPasswordAction($actionToken)
    {
        try {
            
            $userManager = $this->get('user_manager');
            $userManager->resetPassword($actionToken);
            
            $this->get('session')->getFlashBag()->add('success', 'Na Twój adres e-mail zostało wysłane nowe hasło!');
            
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', $ex->getMessage());
        }
        
        return $this->redirect($this->generateUrl('blog_login'));
    }
    
    
    /**
     * @Route(
     *      "/account-activation/{actionToken}",
     *      name = "user_activateAccount"
     * )
     */
    public function activateAccountAction($actionToken)
    {
        try {
            
            $userManager = $this->get('user_manager');
            $userManager->activateAccount($actionToken);
            
            $this->get('session')->getFlashBag()->add('success', 'Twoje konto zostało aktywowane!');
            
        } catch (UserException $ex) {
            $this->get('session')->getFlashBag()->add('error', $ex->getMessage());
        }
        
        return $this->redirect($this->generateUrl('blog_login'));
    }
}
