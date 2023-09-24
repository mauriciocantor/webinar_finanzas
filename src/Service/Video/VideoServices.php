<?php

namespace App\Service\Video;

use App\Entity\ModuleVideo;
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
        $repository = $this->entityManager->getRepository(ModuleVideo::class);

        $query = $repository->createQueryBuilder('v')
//            ->orderBy('v.orderVideo')
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
        $result = array_map(function (ModuleVideo $module) use ($role){
            $module->setVideos($module->getVideos()->filter(static function (Video $video) use ($role) {
                $diff = array_intersect($video->getAvailablesRoles(), $role);
                return count($diff) > 0;
            }));
            return $module;
        }, $allVideos);
        return $result;
    }

    /**
     * @param array $allVideos
     * @param array $role
     * @return array
     */
    public function getRoleFromTestAvailable(array $allVideos, array $role): array
    {
        $result = array_map(function (ModuleVideo $module) use ($role){
            $module->setVideos($module->getVideos()->filter(static function (Video $video) use ($role) {
                $diff = array_intersect($video->getRoleTest(), $role);
                return count($diff) > 0;
            }));
            return $module;
        }, $allVideos);
        return $result;
    }

    public function getTestPassed(array $videos, User $user){
        array_walk($videos, function(Video $video) use ($user){
            $result = $video->getHangmanResultByUser($user);

        });die;
    }
}