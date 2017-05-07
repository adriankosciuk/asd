<?php

namespace Air\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class TaxonomyType extends AbstractType
{

    public function getName()
    {
        return 'taxonomy';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'Tytuł'
            ))
            ->add('slug', 'text', array(
                'label' => 'Alias'
            ))
            ->add('save', 'submit', array(
                'label' => 'Zapisz'
            ));
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Air\BlogBundle\Entity\AbstractTaxonomy'
        ));
    }
}
