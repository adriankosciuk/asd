<?php
namespace Common\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class RegisterUserType extends AbstractType{
    
    public function getName() {
        return 'userRegister';
    }    
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder
            ->add('email', 'email', array(
                'label' => 'E-mail'
            ))
            ->add('username', 'text', array(
                'label' => 'Nick'
            ))
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'first_options' => array(
                    'label' => 'Hasło'
                ),
                'second_options' => array(
                    'label' => 'Powtórz hasło'
                )
            ))
            ->add('submit', 'submit', array(
                'label' => 'Zarejestruj'
            ));
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Common\UserBundle\Entity\User',
            'validation_groups' => array('Default', 'Registration')
        ));
    }
}
