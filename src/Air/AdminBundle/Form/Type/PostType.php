<?php

namespace Air\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PostType extends AbstractType
{

    public function getName()
    {
        return 'post';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'label' => 'Tytuł',
                'attr' => array(
                    'placeholder' => 'Tytuł'
                )
            ))
            ->add('slug', 'text', array(
                'label' => 'Alias',
                'attr' => array(
                    'placeholder' => 'Alias'
                )
            ))
//            ->add('content', 'ckeditor', array(
//                'label' => 'Treść'
//            ))
            ->add('content', 'ckeditor', array(
                'label' => 'Treść'
            ))
            ->add('thumbnailFile', 'file', array(
                'label' => 'Miniaturka'
            ))
            ->add('publishedDate', 'datetime', array(
                'label' => 'Data publikacji',
                'date_widget' => 'single_text', //pokazać też bez
                'time_widget' => 'single_text'
            ))
            ->add('category', 'entity', array(
                'label' => 'Kategoria',
                'class' => 'Air\BlogBundle\Entity\Category',
                'property' => 'name',
                'empty_value' => 'Wybierz kategorię'
            ))
            ->add('tags', 'entity', array(
                'label' => 'Tagi',
                'multiple' => true,
                'class' => 'Air\BlogBundle\Entity\Tag',
                'property' => 'name',
                'attr' => array(
                    'placeholder' => 'Dodaj tagi'
                )
            ))
            ->add('save', 'submit', array(
                'label' => 'Zapisz'
            ));
    }
    
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Air\BlogBundle\Entity\Post'
        ));
    }

}
