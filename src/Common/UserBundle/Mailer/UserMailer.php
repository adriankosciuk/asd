<?php

namespace Common\UserBundle\Mailer;

use Common\UserBundle\Entity\User;


class UserMailer {
    
    /**
     * @var \Swift_Mailer
     */
    private $swiftMailer;
    
    private $fromEmail;
    
    private $fromName;
    
    
    function __construct(\Swift_Mailer $swiftMailer, $fromEmail, $fromName) {
        $this->swiftMailer = $swiftMailer;
        $this->fromEmail = $fromEmail;
        $this->fromName = $fromName;
    }
    
    public function send(User $User, $subject, $htmlBody) {
        $message = \Swift_Message::newInstance()
                        ->setSubject($subject)
                        ->setFrom($this->fromEmail, $this->fromName)
                        ->setTo($User->getEmail(), $User->getUsername())
                        ->setBody($htmlBody, 'text/html');
        
        $this->swiftMailer->send($message);
    }

}
