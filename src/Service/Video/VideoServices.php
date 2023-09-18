<?php

namespace App\Service\Video;

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
        return $this->entityManager->getRepository(Video::class)->findAll();
    }

    public function getVideosByRole(array $role): array
    {
        $allVideos = $this->getAllVideos();
        $videos = $this->getRoleAvailable($allVideos, $role);
        sort($videos);

        return $videos;
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
}