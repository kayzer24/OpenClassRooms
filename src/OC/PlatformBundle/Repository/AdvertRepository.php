<?php

namespace OC\PlatformBundle\Repository;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityRepository;

class AdvertRepository extends EntityRepository
{
    public function getAdvertWithCategories(array $categoryNames){
        $qb = $this->createQueryBuilder('a')
            ->innerJoin('a.categories', 'c')
            ->addSelect('c')
        ;

        $qb->where($qb->expr()->in('c.name', $categoryNames));

        return $qb->getQuery()->getResult();
    }

    public function getAdverts()
    {
        $query = $this->createQueryBuilder('a')
            ->leftJoin('a.image', 'i')
            ->addSelect('i')
            ->leftJoin('a.categories', 'c')
            ->addSelect('c')
            ->orderBy('a.date', 'DESC')
            ->getQuery()
        ;

        return $query->getResult();
    }

    public function getAdvertsBefore(\DateTime $date)
    {
        $qb = $this->createQueryBuilder('a')
            ->where('a.updatedAt <= :date')
            ->orWhere('a.updatedAt IS NULL AND a.date <= :date')
            ->setParameter('date', $date)
            ->getQuery()
        ;

        return $qb->getResult();
    }
}
