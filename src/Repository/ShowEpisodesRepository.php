<?php

namespace App\Repository;

use App\Entity\ShowEpisodes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ShowEpisodes|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShowEpisodes|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShowEpisodes[]    findAll()
 * @method ShowEpisodes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShowEpisodesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShowEpisodes::class);
    }

    // /**
    //  * @return ShowEpisodes[] Returns an array of ShowEpisodes objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ShowEpisodes
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    // public function findAllByShow($showId)
    // {
    //     return $this->findBy(array('show_title' => $showId), array('season' => 'ASC'));
    // }
}
