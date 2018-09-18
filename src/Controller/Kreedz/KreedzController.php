<?php

namespace App\Controller\Kreedz;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\TimesService;
use App\Service\ImagesService;
use App\Model\KreedzModel;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/kreedz")
 */
class KreedzController extends AbstractController
{
    private $types = ['all', 'pro', 'nub'];

    /**
     * @Route("/last", name="kreedz_last")
     */
    public function last(
        Request $request,
        PaginatorInterface $paginator,
        KreedzModel $KreedzModel,
        TimesService $times
    )
    {
        // get request
        $type = $request->query->get('type', 'all');
        $page = $request->query->getInt('page', 1);

        if(!in_array($type, $this->types)) {
            throw $this->createNotFoundException();
        }

        // get last
        $maps = $KreedzModel->getMapLast($type);
        $pagination = $paginator->paginate($maps, $page, 20);

        if($pagination->getPage() > $pagination->getPageCount()) {
            throw $this->createNotFoundException();
        }

        // set vars
        $maps = $pagination->getItems();
        $lastdate = null;
        foreach ($maps as &$map) {
            // Show Header
            $date_add = date("d.m.Y", strtotime($map['time_add']));
            $head = $lastdate!=$date_add ? 1 : 0;
            $lastdate = $date_add;

            // Sets
            $map += [
                'head' => $head,
                'date_add' => $date_add,
                'url_map' => "kreedz/maps/{$map['map']}",
                'url_player' => "kreedz/players/{$map['player']}",
                'timed' => $times->timed($map['time'], 5),
                'color_nogc' => !$map['go_cp'] ? 'green' : 'grey',
                'color_wpn' => ($map['wname']!='USP' && $map['wname']!='KNIFE') ? 'green' : 'grey',
                'map_admin' => 0,
            ];
        }
        $pagination->setItems($maps);

        // Generate type menu
        $types = $this->types;
        foreach ($types as $ctype) {
            $rtypes[] = [
                'type' => $ctype,
                'caption' => ucfirst($ctype),
                'url' => "kreedz/last/?type={$ctype}",
                'active' => $ctype==$type ? 'active' : '',
                'totals' => $ctype==$type ? $pagination->getTotalItemCount() : 0,
            ];
        }

        // render
        return $this->render('controller/kreedz/kreedz/last.html.twig', [
            'title' => 'Kreedz :: Last',
            'pagination' => $pagination,
            'rtypes' => $rtypes,
        ]);
    }

    /**
     * @Route("/players", name="kreedz_players")
     */
    public function players(
        Request $request,
        PaginatorInterface $paginator,
        KreedzModel $KreedzModel
    )
    {
        // get request
        $type = $request->query->get('type', 'all');
        $search = $request->query->get('search');
        $page = $request->query->getInt('page', 1);

        if(!in_array($type, $this->types)) {
            throw $this->createNotFoundException();
        }

        // get last
        $players = $KreedzModel->getPlayers($type, $search);
        $pagination = $paginator->paginate($players, $page, 20);

        if($pagination->getPage() > $pagination->getPageCount()) {
            throw $this->createNotFoundException();
        }

        // set cup nums
        $cup_num = ($page-1)*$pagination->getItemNumberPerPage();

        // set vars
        $players = $pagination->getItems();
        foreach ($players as &$player) {
            $player += [
                'url_player' => "kreedz/players/{$player['id']}",
                'cup_num' => ++$cup_num,
            ];
        }
        $pagination->setItems($players);

        // Generate type menu
        $types = $this->types;
        foreach ($types as $ctype) {
            $rtypes[] = [
                'type' => $ctype,
                'caption' => ucfirst($ctype),
                'url' => "kreedz/players/?".http_build_query(['type'=>$ctype, 'search'=>$search]), // 'sort'=>$sort, 
                'active' => $ctype==$type ? 'active' : '',
                'totals' => $ctype==$type ? $pagination->getTotalItemCount() : 0,
            ];
        }

        // render
        return $this->render('controller/kreedz/kreedz/players.html.twig', [
            'title' => 'Kreedz :: Players',
            'pagination' => $pagination,
            'rtypes' => $rtypes,
            'search' => $search
        ]);
    }

    /**
     * @Route("/players/{id}", name="kreedz_player", requirements={"id"="\d+"})
     */
    public function player(
        $id,
        Request $request,
        PaginatorInterface $paginator,
        KreedzModel $KreedzModel,
        TimesService $times
    )
    {
        // get request
        $type = $request->query->get('type', 'all');
        $search = $request->query->get('search');
        $page = $request->query->getInt('page', 1);

        $player = $KreedzModel->getPlayer($id);
        if(!in_array($type, $this->types) || empty($player)) {
            throw $this->createNotFoundException();
        }

        // get maps
        $maps = $KreedzModel->getPlayerMaps($id, $type, $search);
        $pagination = $paginator->paginate($maps, $page, 20);

        if($pagination->getPage() > $pagination->getPageCount()) {
            throw $this->createNotFoundException();
        }

        // set vars
        $maps = $pagination->getItems();
        foreach ($maps as &$map) {
            $map += [
                'url_map' => "kreedz/maps/{$map['map']}",
                'url_player' => "kreedz/player/{$map['player']}",
                'timed' => $times->timed($map['time'], 5),
                'color_nogc' => !$map['go_cp'] ? 'green' : 'grey',
                'color_wpn' => ($map['wname']!='USP' && $map['wname']!='KNIFE') ? 'green' : 'grey',
                'map_admin' => 0,
            ];
        }
        $pagination->setItems($maps);

        // Generate type menu
        $types = $this->types;
        foreach ($types as $ctype) {
            $rtypes[] = [
                'type' => $ctype,
                'caption' => ucfirst($ctype),
                'url' => "kreedz/players/{$id}/?".http_build_query(['type'=>$ctype, 'search'=>$search]),
                'active' => $ctype==$type ? 'active' : '',
                'totals' => $ctype==$type ? $pagination->getTotalItemCount() : 0,
            ];
        }

        // render
        return $this->render('controller/kreedz/kreedz/player.html.twig', [
            'title' => 'Kreedz :: Player :: '.$player['username'],
            'pagination' => $pagination,
            'rtypes' => $rtypes,
            'player' => $player,
            'search' => $search,
            'url_norec' => "kreedz/players/{$player['id']}/norec",
        ]);
    }

    /**
     * @Route("/players/{id}/norec", name="kreedz_player_norec", requirements={"id"="\d+"})
     */
    public function player_norec(
        $id,
        Request $request,
        PaginatorInterface $paginator,
        KreedzModel $KreedzModel,
        TimesService $times
    )
    {
        // get request
        $search = $request->query->get('search');
        $page = $request->query->getInt('page', 1);

        $player = $KreedzModel->getPlayer($id);
        if(empty($player)) {
            throw $this->createNotFoundException();
        }

        // get last
        $maps = $KreedzModel->getMapsNorec($id);
        $pagination = $paginator->paginate($maps, $page, 20);

        if($pagination->getPage() > $pagination->getPageCount()) {
            throw $this->createNotFoundException();
        }

        // set vars
        $maps = $pagination->getItems();
        foreach ($maps as &$map) {
            $map += [
                'url_map' => "kreedz/map/{$map['mapname']}",
                'url_player' => "kreedz/player/{$map['player']}",
                'timed' => $times->timed($map['time'], 5),
                'color_nogc' => !$map['go_cp'] ? 'green' : 'grey',
                'color_wpn' => ($map['wname']!='USP' && $map['wname']!='KNIFE') ? 'green' : 'grey',
                'map_admin' => 0,
            ];
        }
        $pagination->setItems($maps);

        // render
        return $this->render('controller/kreedz/kreedz/player_norec.html.twig', [
            'title' => 'Kreedz :: Player :: '.$player['username'],
            'pagination' => $pagination,
            'search' => $search,
            'player' => $player,
            'url_jumped' => "kreedz/players/{$player['id']}",
        ]);
    }

    /**
     * @Route("/maps", name="kreedz_maps")
     */
    public function maps(
        Request $request,
        PaginatorInterface $paginator,
        KreedzModel $KreedzModel,
        TimesService $times
    )
    {
        // get request
        $type = $request->query->get('type', 'all');
        $search = $request->query->get('search');
        $page = $request->query->getInt('page', 1);

        if(!in_array($type, $this->types)) {
            throw $this->createNotFoundException();
        }

        // get last
        $maps = $KreedzModel->getMaps($type, $search);
        $pagination = $paginator->paginate($maps, $page, 20);

        if($pagination->getPage() > $pagination->getPageCount()) {
            throw $this->createNotFoundException();
        }

        // set vars
        $maps = $pagination->getItems();
        foreach ($maps as &$map) {
            $map += [
                'url_map' => "kreedz/maps/{$map['map']}",
                'url_player' => "kreedz/players/{$map['player']}",
                'timed' => $times->timed($map['time'], 5),
                'color_nogc' => !$map['go_cp'] ? 'green' : 'grey',
                'color_wpn' => ($map['wname']!='USP' && $map['wname']!='KNIFE') ? 'green' : 'grey',
            ];
        }
        $pagination->setItems($maps);

        // Generate type menu
        $types = $this->types;
        foreach ($types as $ctype) {
            $rtypes[] = [
                'type' => $ctype,
                'caption' => ucfirst($ctype),
                'url' => "kreedz/players/?".http_build_query(['type'=>$ctype, 'search'=>$search]), // 'sort'=>$sort, 
                'active' => $ctype==$type ? 'active' : '',
                'totals' => $ctype==$type ? $pagination->getTotalItemCount() : 0,
            ];
        }

        // render
        return $this->render('controller/kreedz/kreedz/maps.html.twig', [
            'title' => 'Kreedz :: Maps',
            'pagination' => $pagination,
            'rtypes' => $rtypes,
            'search' => $search
        ]);
    }

    /**
     * @Route("/maps/norec", name="kreedz_maps_norec")
     */
    public function maps_norec(
        Request $request,
        PaginatorInterface $paginator,
        KreedzModel $KreedzModel,
        ImagesService $img
    )
    {
        // get request
        $page = $request->query->getInt('page', 1);

        // get last
        $maps = $KreedzModel->getMapsNorec();
        $pagination = $paginator->paginate($maps, $page, 20);

        if($pagination->getPage() > $pagination->getPageCount()) {
            throw $this->createNotFoundException();
        }

        // set vars
        $maps = $pagination->getItems();
        foreach ($maps as &$map) {
            $map += [
                'img_map' => $img->getImage("maps/{$map['mapname']}.jpg"),
            ];
        }
        $pagination->setItems($maps);

        // render
        return $this->render('controller/kreedz/kreedz/maps_norec.html.twig', [
            'title' => 'Kreedz :: Maps :: Not Jumped',
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/maps/{map}", name="kreedz_map")
     */
    public function map(
        $map,
        Request $request,
        PaginatorInterface $paginator,
        KreedzModel $KreedzModel,
        ImagesService $img,
        TimesService $times
    )
    {
        // get request
        $type = $request->query->get('type', 'all');
        $page = $request->query->getInt('page', 1);

        // get last
        $map_count = $KreedzModel->getCountMapTop($map);
        if(empty($map_count) || !in_array($type, $this->types)) {
            throw $this->createNotFoundException();
        }

        // Get Mapinfo
        $mapinfo = $KreedzModel->getMapInfo($map);
        $mapinfo += [
            'img_map' => $img->getImage("maps/{$map}.jpg"),
            'url_map' => "records/map/{$map}",
        ];

        // Map Records
        $maprec = $KreedzModel->getRecords($map);
        $lastcomm = "";
        foreach ($maprec as &$rec) {
            $rec += [
                'url_player' => "records/players/xj/{$rec['player']}",
                'uname' => strtoupper($rec['name']),
                'part' => $rec["comm"]==$lastcomm ? 0 : 1,
                'timed' => $times->timed($rec["time"], 2),
            ];
            $lastcomm = $rec["comm"];
        }
        $mapwr = $maprec[0] ?? '';

        // Get Map Players
        $players = $KreedzModel->getMapPlayers($map, $type);
        $pagination = $paginator->paginate($players, $page, 20);

        if($pagination->getPage() > $pagination->getPageCount()) {
            throw $this->createNotFoundException();
        }

        // set vars
        $players = $pagination->getItems();
        $cup_num = ($page-1)*$pagination->getItemNumberPerPage();
        foreach ($players as &$player) {
            $player += [
                'url_map' => "kreedz/maps/{$player['map']}",
                'url_player' => "kreedz/players/{$player['player']}",
                'timed' => $times->timed($player['time'], 5),
                'color_nogc' => !$player['go_cp'] ? 'green' : 'grey',
                'color_wpn' => ($player['wname']!='USP' && $player['wname']!='KNIFE') ? 'green' : 'gray',
                'cup_num' => ++$cup_num,
            ];
        }
        $pagination->setItems($players);

        // Generate type menu
        $types = $this->types;
        foreach ($types as $ctype) {
            $rtypes[] = [
                'type' => $ctype,
                'caption' => ucfirst($ctype),
                'url' => "kreedz/maps/{$map}/?".http_build_query(['type'=>$ctype]),
                'active' => $ctype==$type ? 'active' : '',
                'totals' => $ctype==$type ? $pagination->getTotalItemCount() : 0,
            ];
        }

        // render
        return $this->render('controller/kreedz/kreedz/map.html.twig', [
            'title' => 'Kreedz :: Map :: '.$map,
            'pagination' => $pagination,
            'mapinfo' => $mapinfo,
            'maprec' => $maprec,
            'mapwr' => $mapwr,
            'rtypes' => $rtypes,
        ]);
    }

    /**
     * @Route("/duels", name="kreedz_duels")
     */
    public function duels(
        Request $request,
        PaginatorInterface $paginator,
        KreedzModel $KreedzModel
    )
    {
        // get request
        $search = $request->query->get('search');
        $page = $request->query->getInt('page', 1);

        // get last
        $duels = $KreedzModel->getDuels();
        $pagination = $paginator->paginate($duels, $page, 20);

        if($pagination->getPage() > $pagination->getPageCount()) {
            throw $this->createNotFoundException();
        }

        // set vars
        $duels = $pagination->getItems();
        foreach ($duels as &$duel) {
            $res = $duel["result1"] > $duel["result2"] ? 0 : 1;
            $pw = $res+1;
            $pl = !$res+1;

            $duel += [
                "winnerId"      => $duel["player$pw"],
                "winnerName"    => $duel["name$pw"],
                "winnerPoints"  => $duel["result$pw"],
                "looserId"      => $duel["player$pl"],
                "looserName"    => $duel["name$pl"],
                "looserPoints"  => $duel["result$pl"],
            ];
            $duel += [
                'url_map' => "kreedz/maps/{$duel['map']}",
                'url_winner' => "kreedz/players/{$duel['winnerId']}",
                'url_looser' => "kreedz/players/{$duel['looserId']}",
            ];
        }
        $pagination->setItems($duels);

        // render
        return $this->render('controller/kreedz/kreedz/duels.html.twig', [
            'title' => 'Kreedz :: Duels',
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/longjumps", name="kreedz_longjumps")
     */
    public function longjumps()
    {
        include "common/ljstats.php";

        return $this->render('controller/kreedz/kreedz/longjumps.html.twig', [
            'title' => 'Kreedz :: Longjumps',
            'url_ljstats' => "/common/ljstats/index.php",
            'html' => $ljstats, 
            'admin' => ''//".($admin ? '?form_admin=1'
        ]);
    }
}
