<?php

namespace Air\BlogBundle\Repository;

use Doctrine\ORM\EntityRepository;


class PostRepository extends EntityRepository {
    
    public function getPublishedPost($slug){
        $qb = $this->getQueryBuilder(array(
            'status' => 'published'
        ));
        
        $qb->andWhere('p.slug = :slug')
                ->setParameter('slug', $slug);
        
        return $qb->getQuery()->getOneOrNullResult();
    }


    public function getQueryBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('p')
                        ->select('p, c, t, a')
                        ->leftJoin('p.category', 'c')
                        ->leftJoin('p.tags', 't')
                        ->leftJoin('p.author', 'a');
        
        if(!empty($params['status'])){
            if('published' == $params['status']){
                $qb->where('p.publishedDate <= :currDate AND p.publishedDate IS NOT NULL')
                        ->setParameter('currDate', new \DateTime());
            }else if('unpublished' == $params['status']){
                $qb->where('p.publishedDate > :currDate OR p.publishedDate IS NULL')
                        ->setParameter('currDate', new \DateTime());
            }
        }
        
        if(!empty($params['orderBy'])){
            $orderDir = !empty($params['orderDir']) ? $params['orderDir'] : NULL;
            $qb->orderBy($params['orderBy'], $orderDir);
        }
        
        if(!empty($params['categorySlug'])){
            $qb->andWhere('c.slug = :categorySlug')
                    ->setParameter('categorySlug', $params['categorySlug']);
        }
        
        if(!empty($params['categoryId'])){
            if(-1 == $params['categoryId']){
                $qb->andWhere($qb->expr()->isNull('p.category'));
            }else{
                $qb->andWhere('c.id = :categoryId')
                        ->setParameter('categoryId', $params['categoryId']);
            }
        }
        
        if(!empty($params['tagSlug'])){
            $qb->andWhere('t.slug = :tagSlug')
                    ->setParameter('tagSlug', $params['tagSlug']);
        }
        
        if(!empty($params['search'])){
            $searchParam = '%'.$params['search'].'%';
            $qb->andWhere('p.title LIKE :searchParam OR p.content LIKE :searchParam')
                    ->setParameter('searchParam', $searchParam);
        }
        
        if(!empty($params['titleLike'])){
            $titleLike = '%'.$params['titleLike'].'%';
            $qb->andWhere('p.title LIKE :titleLike')
                    ->setParameter('titleLike', $titleLike);
        }
                
        return $qb;
    }
    
    
    public function getRecentCommented($limit = 3) {
        
        $qb = $this->createQueryBuilder('p')
                    ->select('p.title, p.slug, COUNT(c) as commentsCount')
                    ->leftJoin('p.comments', 'c')
                    ->groupBy('p.title')
                    ->having('commentsCount > 0')
                    ->where('p.publishedDate <= :currDate AND p.publishedDate IS NOT NULL')
                    ->setParameter('currDate', new \DateTime())
                    ->orderBy('commentsCount', 'DESC')
                    ->setMaxResults($limit);
        
        return $qb->getQuery()->getArrayResult();
    }
    
    public function getStatistics(){
        $qb = $this->createQueryBuilder('p')
                        ->select('COUNT(p)');
        
        
        $all = (int)$qb->getQuery()->getSingleScalarResult();
        
        $published = (int)$qb->andWhere('p.publishedDate <= :currDate AND p.publishedDate IS NOT NULL')
                            ->setParameter('currDate', new \DateTime())
                            ->getQuery()
                            ->getSingleScalarResult();
        
        return array(
            'all' => $all,
            'published' => $published,
            'unpublished' => ($all - $published)
        );
    }
    
    public function moveToCategory($oldCategoryId, $newCategoryId) {
        return $this->createQueryBuilder('p')
                ->update()
                ->set('p.category', ':newCategoryId')
                ->where('p.category = :oldCategoryId')
                ->setParameters(array(
                    'newCategoryId' => $newCategoryId,
                    'oldCategoryId' => $oldCategoryId
                ))
                ->getQuery()
                ->execute();
    }
}
