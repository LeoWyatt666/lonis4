<?php

namespace App\Controller\Players;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\CsPlayers;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\GeoIp2Service;
use App\Service\TimesService;
use App\Service\ImagesService;
use Ornicar\GravatarBundle\GravatarApi;

/**
 * @Route("/players")
 */
class PlayersController extends AbstractController
{
    /**
     * @Route("/", name="players")
     */
    public function players(
        Request $request, 
        PaginatorInterface $paginator, 
        GeoIp2Service $geoip,
        ImagesService $img
    )
    {
        $gravatar = new GravatarApi;

        // get request
        $search = $request->query->get('search');
        $page = $request->query->getInt('page', 1);

        // get query
        $query = $this->getDoctrine()
            ->getRepository(CsPlayers::class)
            ->queryAll($search);

        // get result
        $pagination = $paginator->paginate($query, $page, 20);

        if($pagination->getPage() > $pagination->getPageCount()) {
            throw $this->createNotFoundException();
        }

        // set data
        foreach ($pagination->getItems() as &$player) {
            $player->url_player = "players/{$player->getId()}";
            //$player->url_avatar = $img->image("avatars/{$player->getId()}.jpg");
            $player->url_avatar = $gravatar->getUrl($player->getId(), '160').'&d=robohash';
            
            $player->geoip = $geoip->city($player->getLastIp());
        }
        
        // render
        return $this->render('controller/players/players/players.html.twig', [
            'title' => 'Players',
            'pagination' => $pagination,
            'search' => $search,
        ]);
    }

    /**
     * @Route("/{id}", name="player")
     */
    public function player(
        CsPlayers $player,
        GeoIp2Service $geoip,
        TimesService $times,
        ImagesService $img
    )
    {
        $gravatar = new GravatarApi;

        // set result
        $player->lastTime = date('d.m.Y G:i:s', $player->getLastTime());
        $player->mapCompleted = 0;
        $player->onlineTimeElasped = $times->time_elasped($player->getOnlineTime());
        $player->url_kreedz_player = "kreedz/players/{$player->getId()}";
        $player->url_achievs_player = "achievs/players/{$player->getId()}";
        //$player->img_player = $img->image("avatars/{$player->getId()}.jpg");
        $player->img_player = $gravatar->getUrl($player->getId(), '240').'&d=robohash';

        $player->geoip = $geoip->city($player->getLastIp());

        $player->achievCompleted = '-';
        $player->mapCompleted = '-';

        // render
        return $this->render('controller/players/players/player.html.twig', [
            'title' => 'Player',
            'player' => $player,
        ]);
    }
}
