<?php

namespace App\Repository;

use App\Entity\AlphabetSoupResult;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AlphabetSoupResult>
 *
 * @method AlphabetSoupResult|null find($id, $lockMode = null, $lockVersion = null)
 * @method AlphabetSoupResult|null findOneBy(array $criteria, array $orderBy = null)
 * @method AlphabetSoupResult[]    findAll()
 * @method AlphabetSoupResult[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlphabetSoupResultRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AlphabetSoupResult::class);
    }

//    /**
//     * @return AlphabetSoupResult[] Returns an array of AlphabetSoupResult objects
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

//    public function findOneBySomeField($value): ?AlphabetSoupResult
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
