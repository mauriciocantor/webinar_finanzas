<?php

namespace App\Repository;

use App\Entity\ModuleVideo;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ModuleVideo>
 *
 * @method ModuleVideo|null find($id, $lockMode = null, $lockVersion = null)
 * @method ModuleVideo|null findOneBy(array $criteria, array $orderBy = null)
 * @method ModuleVideo[]    findAll()
 * @method ModuleVideo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModuleVideoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ModuleVideo::class);
    }

//    /**
//     * @return ModuleVideo[] Returns an array of ModuleVideo objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ModuleVideo
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    /**
     * @param User $user
     * @return float|int|mixed|string
     */
    public function getVideoCorrectByUser(User $user): mixed
    {
        return $this->createQueryBuilder('m')
            ->select([
                'm.name',
                'CONCAT(\'Video No \',v.id) as Video',
                'NULLIF(SUM(hr.isCorrect),0) as Hangman_Correct',
                'NULLIF(SUM(asoupr.isCorrect),0) as Soup_Correct'
            ])
            ->innerJoin('m.videos','v')
            ->leftJoin('v.hangmanResults', 'hr', 'WITH', 'hr.user = :user and hr.isCorrect = 1')
            ->leftJoin('v.alphabetSoups', 'asoup')
            ->leftJoin('asoup.alphabetSoupResults', 'asoupr', 'WITH', 'asoupr.user = :user and asoupr.isCorrect = 1')
            ->setParameter('user', $user)
            ->groupBy('m.id, v.id')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return mixed
     */
    public function getVideoCorrects(): mixed
    {
        return $this->createQueryBuilder('m')
            ->select([
                'm.name',
                'CONCAT(\'Video No \',v.id) as Video',
                'NULLIF(SUM(hr.isCorrect),0) as Hangman_Correct',
                'NULLIF(SUM(asoupr.isCorrect),0) as Soup_Correct'
            ])
            ->innerJoin('m.videos','v')
            ->leftJoin('v.hangmanResults', 'hr', 'WITH', 'hr.isCorrect = 1')
            ->leftJoin('v.alphabetSoups', 'asoup')
            ->leftJoin('asoup.alphabetSoupResults', 'asoupr', 'WITH', 'asoupr.isCorrect = 1')

//            ->setParameter('user', $user)
//            ->groupBy('m.id, v.id')
//            ->where('JSON_SEARCH(u.roles, \'one\', \'ROLE_ADMIN\') is NULL')
            ->getQuery()
            ->getResult();
    }
}
