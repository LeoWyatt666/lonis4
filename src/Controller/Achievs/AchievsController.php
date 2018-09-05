<?php

namespace App\Controller\Achievs;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AchievsController extends AbstractController
{
    /**
     * @Route("/cstrike/achievs", name="cstrike_achievs")
     */
    public function index()
    {
        return $this->render('cstrike/achievs/index.html.twig', [
            'controller_name' => 'AchievsController',
        ]);
    }

    /**
     * @Route("/cstrike/achievs/{id}", name="cstrike_achiev")
     */
    public function achiev()
    {
        return $this->render('cstrike/achievs/achiev.html.twig', [
            'controller_name' => 'AchievsController-Achiev',
        ]);
    }

     /**
     * @Route("/cstrike/achievs/players", name="cstrike_achievs_players")
     */
    public function players()
    {
        return $this->render('cstrike/achievs/players.html.twig', [
            'controller_name' => 'AchievsController-Players',
        ]);
    }

     /**
     * @Route("/cstrike/achievs/players/{id}", name="cstrike_achievs_player")
     */
    public function player()
    {
        return $this->render('cstrike/achievs/player.html.twig', [
            'controller_name' => 'AchievsController-Player',
        ]);
    }
}
