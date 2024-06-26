<?php

namespace App\Repository;

use App\Entity\Fund;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Fund>
 *
 * @method Fund|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fund|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fund[]    findAll()
 * @method Fund[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FundRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fund::class);
    }

//    /**
//     * @return Fundh[] Returns an array of Fundh objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Fundh
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
