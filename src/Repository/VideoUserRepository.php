<?php

namespace App\Repository;

use App\Entity\VideoUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VideoUser>
 *
 * @method VideoUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method VideoUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method VideoUser[]    findAll()
 * @method VideoUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VideoUser::class);
    }

//    /**
//     * @return VideoUser[] Returns an array of VideoUser objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?VideoUser
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
