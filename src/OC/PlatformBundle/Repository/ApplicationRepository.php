<?php

namespace OC\PlatformBundle\Repository;


class ApplicationRepository extends \Doctrine\ORM\EntityRepository
{
    public function getApplicationsWithAdvert($limit)
    {
        $qb = $this->createQueryBuilder('a');

        $qb
            ->innerJoin('a.advert', 'adv')
            ->addSelect('adv')
        ;

        $qb->setMaxResults($limit);

        return $qb
            ->getQuery()
            ->getResult()
            ;
    }
}
