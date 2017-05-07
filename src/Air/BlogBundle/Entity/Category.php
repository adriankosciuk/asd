<?php

namespace Air\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="Air\BlogBundle\Repository\CategoryRepository")
 * @ORM\Table(name="blog_categories")
 */
class Category extends AbstractTaxonomy {
    
    /**
     * @ORM\OneToMany(
     *      targetEntity = "Post",
     *      mappedBy = "category"
     * )
     */
    protected $posts;
    
    
}
