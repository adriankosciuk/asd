<?php

namespace Air\BlogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Validator\Constraints as Assert;


class ContactType extends AbstractType {
        
    public function getName() {
        return 'contact';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('name', 'text', array(
                'label' => 'Imię i nazwisko',
                'constraints' => array(
                    new Assert\NotBlank()
                )
            ))
            ->add('email', 'email', array(
                'label' => 'Email',
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Email()
                )
            ))
            ->add('message', 'textarea', array(
                'label' => 'Twoja wiadomość',
                'constraints' => array(
                    new Assert\NotBlank()
                )
            ))
            ->add('save', 'submit', array(
                'label' => 'Wyślij'
            ));
    }
}
