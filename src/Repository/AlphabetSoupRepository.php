<?php

namespace App\Repository;

use App\Entity\AlphabetSoup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AlphabetSoup>
 *
 * @method AlphabetSoup|null find($id, $lockMode = null, $lockVersion = null)
 * @method AlphabetSoup|null findOneBy(array $criteria, array $orderBy = null)
 * @method AlphabetSoup[]    findAll()
 * @method AlphabetSoup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlphabetSoupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AlphabetSoup::class);
    }

//    /**
//     * @return AlphabetSoup[] Returns an array of AlphabetSoup objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AlphabetSoup
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
