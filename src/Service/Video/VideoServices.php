<?php

namespace App\Service\Video;

use App\Entity\User;
use App\Entity\Video;
use Doctrine\ORM\EntityManagerInterface;

class VideoServices
{
    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAllVideos(): array
    {
        $repository = $this->entityManager->getRepository(Video::class);

        $query = $repository->createQueryBuilder('v')
            ->orderBy('v.orderVideo')
            ->getQuery();

        return $query->getResult();

    }

    public function getVideosByRole(array $role): array
    {
        $allVideos = $this->getAllVideos();
        //sort($videos);

        return $this->getRoleAvailable($allVideos, $role);
    }

    /**
     * @param array $allVideos
     * @param array $role
     * @return array
     */
    public function getRoleAvailable(array $allVideos, array $role): array
    {
        return array_filter($allVideos, static function (Video $video) use ($role) {
            $diff = array_intersect_assoc($video->getAvailablesRoles(), $role);
            return count($diff) > 0;
        });
    }

    /**
     * @param array $allVideos
     * @param array $role
     * @return array
     */
    public function getRoleFromTestAvailable(array $allVideos, array $role): array
    {
        return array_filter($allVideos, static function (Video $video) use ($role) {
            $diff = array_intersect_assoc($video->getRoleTest(), $role);
            return count($diff) > 0;
        });
    }

    public function getTestPassed(array $videos, User $user){
        array_walk($videos, function(Video $video) use ($user){
            $result = $video->getHangmanResultByUser($user);

        });die;
    }
}