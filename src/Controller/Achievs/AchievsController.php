<?php

namespace App\Controller\Achievs;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\AcAchievs;
use App\Service\InfiniteScrollService;
use App\Model\AchievsModel;
use Knp\Component\Pager\PaginatorInterface;

class AchievsController extends AbstractController
{
    /**
     * @Route("/achievs", name="achievs")
     */
    public function achievs(
        Request $request,
        PaginatorInterface $paginator,
        InfiniteScrollService $infscr,
        AchievsModel $AchievsModel
    )
    {
        // get request
        $page = $request->query->getInt('page', 1);
        $locale = $request->getLocale();

        $achievs = $AchievsModel->getAchievs($locale);
        $pagination = $paginator->paginate($achievs, $page, 20);

        // foreach ($achievs as &$achiev) {
        //     $achiev += [
        //         'completer' => round($achiev["completed"], 2),
        //         'img_achiev' => $this->achievImg($achiev['aId']),
        //         'url_achiev' => "achievs/achiev/{$achiev['aId']}",
        //     ];
        // }

        return $this->render('achievs/achievs/achievs.html.twig', [
            'title'         => 'Achievs',
            'pagination'    => $pagination,
        ]);
    }

    /**
     * @Route("/achievs/{id}", name="achiev", requirements={"id"="\d+"})
     */
    public function achiev(
        $id,
        Request $request,
        PaginatorInterface $paginator,
        InfiniteScrollService $infscr,
        AchievsModel $AchievsModel
    )
    {
        $page = $request->query->getInt('page', 1);
        $locale = $request->getLocale();

        $achiev = $AchievsModel->getAchiev($locale, $id);

        if(!$achiev) { 
            throw $this->createNotFoundException(); 
        }
        
        $achiev += [
            'img_achiev' => $this->achievImg($achiev["id"]),
        ];

        $players = $AchievsModel->getAchievPlayers($id);
        $pagination = $paginator->paginate($players, $page, 20);

        // set infinite scroll
        $pagination = $infscr->setPaginationNext($pagination, $request);

        $players = $pagination->getItems();
        foreach ($players as &$player) {
            $player += [
                'img_player' => "images/avatars/{$player['id']}.jpg",
                'url_player' => "achievs/player/{$player['id']}",
            ];
        }
        $pagination->setItems($players);

        return $this->render('achievs/achievs/achiev.html.twig', [
            'title'          => 'Achiev Players',
            'achiev'        => $achiev,
            'pagination'    => $pagination,
        ]);
    }

     /**
     * @Route("/achievs/players", name="achievs_players")
     */
    public function players(
        Request $request,
        PaginatorInterface $paginator,
        InfiniteScrollService $infscr,
        AchievsModel $AchievsModel
    )
    {
        $page = $request->query->getInt('page', 1);

        $players = $AchievsModel->getAchievsPlayers();
        $pagination = $paginator->paginate($players, $page, 20);

        foreach ($players as &$player) {
            $player += [
                'url_image' => "images/avatars/{$player['id']}.jpg",
                'url_player' => "achievs/player/{$player['id']}",
            ];
        }

        return $this->render('achievs/achievs/players.html.twig', [
            'title' => 'Achievs Players',
            'pagination'    => $pagination,
        ]);
    }

     /**
     * @Route("/achievs/players/{id}", name="achievs_player", requirements={"id"="\d+"})
     */
    public function player(
        $id,
        Request $request,
        PaginatorInterface $paginator,
        InfiniteScrollService $infscr,
        AchievsModel $AchievsModel
    )
    {
        $locale = $request->getLocale();
        $page = $request->query->getInt('page', 1);

        $achievs = $AchievsModel->getAchievsPlayer($locale, $id);

        if(!$achievs) { 
            throw $this->createNotFoundException(); 
        }

        $pagination = $paginator->paginate($players, $page, 20);

        // Get all rows and sets
        // foreach ($achievs as &$achiev) {
        //     if ($achiev["count"] != 1 && $achiev["count"] != $achiev["progress"]) {
        //         $achiev["width"] = $achiev["progress"] * 100 / $achiev["count"];
        //     }
            
        //     if ($achiev['count']==$achiev['progress']) {
        //         $achiev["achiev_completed"] = 'achiev_completed';
        //     }

        //     $achiev += [
        //         'img_achiev' => $this->achievImg($achiev['id']),
        //         'url_achiev' => "achievs/achiev/{$achiev['id']}",
        //         'isset_ahciev_width' => isset($achiev['width']),
        //     ];

        //     if (isset($achiev['unlocked'])) {
        //         $achiev['unlocked'] = date_format($achiev['unlocked'], "%d.%m.%Y %H:%M");
        //     }
        // }

        return $this->render('achievs/achievs/player.html.twig', [
            'title' => 'Achives Player',
        ]);
    }

    private function achievImg($id)
    {
        return "http://gravatar.com/avatar/".md5($id)."?d=identicon";
    }
}
