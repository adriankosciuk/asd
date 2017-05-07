<?php

namespace Air\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Air\BlogBundle\Entity\Tag;


class TagsFixtures extends AbstractFixture implements OrderedFixtureInterface {
    
    public function load(ObjectManager $manager) {
        
        $tagsList = array(
            'dolor', 
            'ullamcorper', 
            'suspendisse', 
            'pellentesque', 
            'maecenas', 
            'malesuada', 
            'ultricies',
            'etiam', 
            'quisque', 
            'fringilla', 
            'eleifend',
            'bibendum',
            'faucibus',
            'luctus',
            'vestibulum'
        );
        
        foreach ($tagsList as $key => $name) {
            $Tag = new Tag();
            $Tag->setName($name);
            
            $manager->persist($Tag);
            $this->addReference('tag_'.$name, $Tag);
        }
        
        $manager->flush();
    }
    
    public function getOrder() {
        return 0;
    }

}
