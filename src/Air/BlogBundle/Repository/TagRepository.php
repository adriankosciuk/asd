<?php

namespace Air\BlogBundle\Repository;

class TagRepository extends TaxonomyRepository {
    
    public function getTagsListOcc(){
        $qb = $this->createQueryBuilder('t')
                        ->select('t.slug, t.name, COUNT(p) as occ')
                        ->leftJoin('t.posts', 'p')
                        ->groupBy('t.name');
        
        return $qb->getQuery()->getArrayResult();
    }
    
}
