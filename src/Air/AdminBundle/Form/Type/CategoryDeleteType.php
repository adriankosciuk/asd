<?php

namespace Air\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;


class CategoryDeleteType extends AbstractType {
    
    private $category;

    function __construct($category) {
        $this->category = $category;
    }

    public function getName() {
        return 'deleteCategory';
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $Category = $this->category;
        
        $builder
            ->add('setNull', 'checkbox', array(
                'label' => 'Ustaw wszystkie posty bez kategorii'
            ))
            ->add('newCategory', 'entity', array(
                'label' => 'Wybierz nową kategorię dla postów',
                'empty_value' => 'Wybierz kategorię',
                'class' => 'Air\BlogBundle\Entity\Category',
                'property' => 'name',
                'query_builder' => function(EntityRepository $er) use ($Category){
                    return $er->createQueryBuilder('c')
                                    ->where('c.id != :categoryId')
                                    ->setParameter('categoryId', $Category->getId());
                }
            ))
            ->add('submit', 'submit', array(
                    'label' => 'Usuń kategorię'
            ));
    }
}
