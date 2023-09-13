<?php

namespace App\Service;

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
        $videos = array_filter($allVideos, static function(Video $video) use ($role){
            $diff = array_diff($video->getAvailablesRoles(), $role);
            return count($diff)<=0;
        });
        sort($videos);

        return $videos;
    }
}