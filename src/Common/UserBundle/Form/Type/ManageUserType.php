<?php

namespace Common\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ManageUserType extends AbstractType
{  
    
    public function getName()
    {
        return 'manageUser';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text', array(
                'label' => 'Nick',
                'attr' => array(
                    'placeholder' => 'Nick'
                )
            ))
            ->add('email', 'email', array(
                'label' => 'E-mail',
                'attr' => array(
                    'placeholder' => 'E-mail'
                )
            ))
            ->add('accountExpired', 'checkbox', array(
                'label' => 'Konto wygasło'
            ))
            ->add('accountLocked', 'checkbox', array(
                'label' => 'Konto zablokowane'
            ))
            ->add('credentialsExpired', 'checkbox', array(
                'label' => 'Dane uwierzytelniające wygasły'
            ))
            ->add('enabled', 'checkbox', array(
                'label' => 'Konto aktywowane'
            ))
            ->add('roles', 'choice', array(
                'label' => 'Role',
                'multiple' => true,
                'choices' => array(
                    'ROLE_USER' => 'Użytkownik',
                    'ROLE_EDITOR' => 'Redaktor',
                    'ROLE_ADMIN' => 'Administrator',
                    'ROLE_SUPER_ADMIN' => 'Super Administrator'
                )
            ))
            ;
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Common\UserBundle\Entity\User'
        ));
    }

    
}