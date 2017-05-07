<?php

namespace Common\UserBundle\Manager;

use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface as Templating;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Common\UserBundle\Mailer\UserMailer;
use Common\UserBundle\Entity\User;
use Common\UserBundle\Exception\UserException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class UserManager {
    
    /**
     * @var Doctrine
     */
    protected $doctrine;
        
    /**
     * @var Router
     */
    protected $router;
    
    /**
     * @var Templating 
     */
    protected $templating;
    
    /**
     * @var EncoderFactory
     */
    protected $encoderFactory;
    
    /**
     * @var UserMailer
     */
    protected $userMailer;
    
    
    function __construct(Doctrine $doctrine, Router $router, Templating $templating, EncoderFactory $encoderFactory, UserMailer $userMailer) {
        $this->doctrine = $doctrine;
        $this->router = $router;
        $this->templating = $templating;
        $this->encoderFactory = $encoderFactory;
        $this->userMailer = $userMailer;
    }
    
    protected function generateActionToken() {
        return substr(md5(uniqid(NULL, TRUE)), 0, 20);
    }
    
    protected function getRandomPassword($length = 8){
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
    
    public function sendResetPasswordLink($userEmail) {
        
        $User = $this->doctrine->getRepository('CommonUserBundle:User')
                        ->findOneByEmail($userEmail);
        
        if(null === $User){
            throw new UserException('Nie znaleziono takiego użytkownika.');
        }
        
        $User->setActionToken($this->generateActionToken());
        
        $em = $this->doctrine->getManager();
        $em->persist($User);
        $em->flush();
        
        $urlParams = array(
            'actionToken' => $User->getActionToken()
        );
        
        $resetUrl = $this->router->generate('user_resetPassword', $urlParams, UrlGeneratorInterface::ABSOLUTE_URL);
        
        $emailBody = $this->templating->render('CommonUserBundle:Email:passwdResetLink.html.twig', array(
            'resetUrl' => $resetUrl
        ));
        
        $this->userMailer->send($User, 'Link resetujący hasło', $emailBody);
        
        return true;
    }
    
    public function resetPassword($actionToken) {
        
        $User = $this->doctrine->getRepository('CommonUserBundle:User')
                        ->findOneByActionToken($actionToken);
        
        if(null === $User){
            throw new UserException('Podano błędnę parametry akcji.');
        }
        
        $plainPasswd = $this->getRandomPassword();
        
        $encoder = $this->encoderFactory->getEncoder($User);
        $encodedPasswd = $encoder->encodePassword($plainPasswd, $User->getSalt());
        
        $User->setPassword($encodedPasswd);
        $User->setActionToken(null);
        
        $em = $this->doctrine->getManager();
        $em->persist($User);
        $em->flush();
        
        $emailBody = $this->templating->render('CommonUserBundle:Email:newPassword.html.twig', array(
            'plainPasswd' => $plainPasswd
        ));
        
        $this->userMailer->send($User, 'Nowe hasło do konta', $emailBody);
        
        return true;
    }
    
    public function registerUser(User $User) {
        
        if(null !== $User->getId()){
            throw new UserException('Użytkownik jest już zarejestrowany');
        }
        
        $encoder = $this->encoderFactory->getEncoder($User);
        $encodedPasswd = $encoder->encodePassword($User->getPlainPassword(), $User->getSalt());
        
        $User->setPassword($encodedPasswd);
        $User->setActionToken($this->generateActionToken());
        $User->setEnabled(false);
        
        $em = $this->doctrine->getManager();
        $em->persist($User);
        $em->flush();
        
        $urlParams = array(
            'actionToken' => $User->getActionToken()
        );
        $activationUrl = $this->router->generate('user_activateAccount', $urlParams, UrlGeneratorInterface::ABSOLUTE_URL);
        
        $emaiBody = $this->templating->render('CommonUserBundle:Email:accountActivation.html.twig', array(
            'activationUrl' => $activationUrl
        ));
        
        $this->userMailer->send($User, 'Aktywacja konta', $emaiBody);
        
        return true;
    }
    
    public function activateAccount($actionToken){
        $User = $this->doctrine->getRepository('CommonUserBundle:User')
                        ->findOneByActionToken($actionToken);
        
        if(null === $User){
            throw new UserException('Podano błędnę parametry akcji.');
        }
        
        $User->setEnabled(true);
        $User->setActionToken(null);
        
        $em = $this->doctrine->getManager();
        $em->persist($User);
        $em->flush();
        
        return true;
    }
    
    public function changePassword(User $User){
        
        if(null == $User->getPlainPassword()){
            throw new UserException('Nie ustawiono nowego hasła!');
        }

        $encoder = $this->encoderFactory->getEncoder($User);
        $encoderPassword = $encoder->encodePassword($User->getPlainPassword(), $User->getSalt());
        $User->setPassword($encoderPassword);

        $em = $this->doctrine->getManager();
        $em->persist($User);
        $em->flush();

        return true;
    }
}
