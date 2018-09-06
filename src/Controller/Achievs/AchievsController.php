<?php

namespace App\Controller\Achievs;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AchievsController extends AbstractController
{
    /**
     * @Route("/achievs", name="achievs")
     */
    public function achievs()
    {
        return $this->render('achievs/achievs/achievs.html.twig', [
            'title' => 'AchievsController',
        ]);
    }

    /**
     * @Route("/achievs/{id}", name="achiev", requirements={"id"="\d+"})
     */
    public function achiev()
    {
        return $this->render('achievs/achievs/achiev.html.twig', [
            'title' => 'AchievsController-Achiev',
        ]);
    }

     /**
     * @Route("/achievs/players", name="achievs_players")
     */
    public function players()
    {
        return $this->render('achievs/achievs/players.html.twig', [
            'title' => 'AchievsController-Players',
        ]);
    }

     /**
     * @Route("/achievs/players/{id}", name="achievs_player", requirements={"id"="\d+"})
     */
    public function player()
    {
        return $this->render('achievs/achievs/player.html.twig', [
            'title' => 'AchievsController-Player',
        ]);
    }
}
