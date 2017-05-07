<?php

namespace Air\BlogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class CommentType extends AbstractType {
        
    public function getName() {
        return 'comment';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('comment', 'textarea', array(
                'label' => 'Komentarz'
            ))
            ->add('save', 'submit', array(
                'label' => 'Dodaj'
            ));
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Air\BlogBundle\Entity\Comment'
        ));
    }
}
