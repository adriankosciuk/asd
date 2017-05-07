<?php

namespace Common\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Common\UserBundle\Entity\User;


class UsersFixtures extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface{
    
    /**
     *
     * @var ContainerInterface
     */
    private $container;
    
    public function getOrder() {
        return 0;
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function load(ObjectManager $manager) {
        
        $usersList = array(
            array(
                'nick' => 'adas_no',
                'email' => 'anowak@eduweb.pl',
                'password' => '123',
                'role' => 'ROLE_USER'
            ),
            array(
                'nick' => 'kowal',
                'email' => 'j.kowalski@eduweb.pl',
                'password' => '123',
                'role' => 'ROLE_EDITOR'
            ),
            array(
                'nick' => 'antkow',
                'email' => 'a.nowakowski@eduweb.pl',
                'password' => '123',
                'role' => 'ROLE_ADMIN'
            ),
            array(
                'nick' => 'macq',
                'email' => 'macq@eduweb.pl',
                'password' => '123',
                'role' => 'ROLE_SUPER_ADMIN'
            ),
        );
        
        $encoderFactory = $this->container->get('security.encoder_factory');
        
        foreach ($usersList as $userDetails) {
            $User = new User();
            
            $password = $encoderFactory->getEncoder($User)->encodePassword($userDetails['password'], null);
            
            $User->setUsername($userDetails['nick'])
                    ->setEmail($userDetails['email'])
                    ->setPassword($password)
                    ->setRoles(array($userDetails['role']))
                    ->setEnabled(true);
            
            $this->addReference('user-'.$userDetails['nick'], $User);
            
            $manager->persist($User);
            
        }
        
        $manager->flush();
        
    }

    

}
