<?php

namespace App\Repository;

use App\Entity\HangmanResult;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HangmanResult>
 *
 * @method HangmanResult|null find($id, $lockMode = null, $lockVersion = null)
 * @method HangmanResult|null findOneBy(array $criteria, array $orderBy = null)
 * @method HangmanResult[]    findAll()
 * @method HangmanResult[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HangmanResultRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HangmanResult::class);
    }

//    /**
//     * @return HangmanResult[] Returns an array of HangmanResult objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?HangmanResult
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
