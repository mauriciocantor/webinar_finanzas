<?php

namespace App\Service\Video;

use App\Entity\User;
use App\Entity\Video;
use App\Entity\VideoUser;
use Doctrine\ORM\EntityManagerInterface;

class SaveVideo
{
    private VideoUser $videoUser;
    private Video $video;
    private User $user;
    private EntityManagerInterface $entityManager;

    /**
     * @param VideoUser $videoUser
     * @param Video $video
     * @param User $user
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        VideoUser $videoUser,
        Video $video,
        User $user,
        EntityManagerInterface $entityManager
    )
    {

        $this->videoUser = $videoUser;
        $this->video = $video;
        $this->user = $user;
        $this->entityManager = $entityManager;
    }

    public function saveVideoByUser(array $parameters){
        $user = $this->entityManager->getRepository(User::class)->find($parameters['user']);
        $video = $this->entityManager->getRepository(Video::class)->find($parameters['video']);

        $videoByUser = $this->getVideoByUser($user, $video);

        if($videoByUser){
            $videoByUser->setTotalTime($parameters['totalTime']);
            $videoByUser->setCurrentTime($parameters['currentTime']);
        }else{
            $videoByUser = new VideoUser();
            $videoByUser->setUser($user);
            $videoByUser->setVideo($video);
            $videoByUser->setCurrentTime($parameters['currentTime']);
            $videoByUser->setTotalTime($parameters['totalTime']);
        }

        $this->entityManager->persist($videoByUser);
        return $this->entityManager->flush();
    }

    public function getVideoByUser(User $user, Video $video){
        return $this->entityManager->getRepository(VideoUser::class)
            ->findOneBy(['user'=>$user, 'video'=>$video]);
    }
}