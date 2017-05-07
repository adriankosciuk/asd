<?php

namespace Common\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class AccountSettingsType extends AbstractType{
    
    public function getName() {
        return 'accountSettings';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('username', 'text', array(
                    'label' => 'Nick',
                    'required' => FALSE
                ))
                ->add('avatarFile', 'file', array(
                    'label' => 'Zmień avatar',
                    'required' => FALSE
                ))
                ->add('submit', 'submit', array(
                    'label' => 'Zapisz zmiany'
                ));
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Common\UserBundle\Entity\User',
            'validation_groups' => array('Default', 'ChangeDetails')
        ));
    }
    
}