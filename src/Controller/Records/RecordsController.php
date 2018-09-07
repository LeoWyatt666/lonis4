<?php

namespace App\Controller\Records;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\KzRecords;
use App\Service\InfiniteScrollService;
use App\Service\TimesService;
use App\Model\RecordsModel;
use Knp\Component\Pager\PaginatorInterface;

class RecordsController extends AbstractController
{
    /**
     * @Route("/records/demos/{comm}", name="records_demos")
     */
    public function demos(
        $comm = 'xj',
        Request $request,
        PaginatorInterface $paginator,
        InfiniteScrollService $infscr,
        RecordsModel $RecordsModel,
        TimesService $times
    )
    {
        // get request
        $page = $request->query->getInt('page', 1);

        // get players
        $demos = $RecordsModel->getDemos($comm);
        $pagination = $paginator->paginate($demos, $page, 20);

        // set vars
        $demos = $pagination->getItems();
        foreach ($demos as &$demo) {
            $demo += [
                'url_map' => "records/maps/{$comm}/{$demo['map']}",
                'timed' => $times->timed($demo['time'], 2),
                'url_player' => "records/player/{$demo['player']}",
            ];
        }
        $pagination->setItems($demos);

        // set infinite scroll
        $pagination = $infscr->setPaginationNext($pagination, $request);

        // Get community data
        $comm_info = $RecordsModel->getComms($comm);
        $comm_list = $RecordsModel->getComms();

        // set vars
        foreach ($comm_list as &$row) {
            $row += [
                'url_comm' => "records/demos/{$row['name']}",
                'active' => $row['name']==$comm_info['name'] ? 'active' : '',
                'totals' => $row['name']==$comm_info['name'] ? $pagination->getTotalItemCount() : 0,
            ];
        }

        return $this->render('records/records/demos.html.twig', [
            'title' => 'Demos',
            'pagination' => $pagination,
            'comm_list' => $comm_list,
        ]);
    }

    /**
     * @Route("/records/players/{comm}", name="records_players")
     */
    public function players(
        $comm = "xj",
        Request $request,
        PaginatorInterface $paginator,
        InfiniteScrollService $infscr,
        RecordsModel $RecordsModel
    )
    {
        // get request
        $page = $request->query->getInt('page', 1);

        // get players
        $players = $RecordsModel->getPlayers($comm);
        $pagination = $paginator->paginate($players, $page, 20);

        // set infinite scroll
        $pagination = $infscr->setPaginationNext($pagination, $request);

        // set cup nums
        $cup_num = ($page-1)*$pagination->getItemNumberPerPage();
        
        // set vars
        $players = $pagination->getItems();
        foreach ($players as &$player) {
            $player += [
                'url_player' => "records/players/{$comm}/{$player['player']}",
                'cup_num' => ++$cup_num,
            ];
        }
        $pagination->setItems($players);

        // Get community data
        $comm_info = $RecordsModel->getComms($comm);
        $comm_list = $RecordsModel->getComms();

        // set vars
        foreach ($comm_list as &$row) {
            $row += [
                'url_comm' => "records/players/{$row['name']}",
                'active' => $row['name']==$comm_info['name'] ? 'active' : '',
                'totals' => $row['name']==$comm_info['name'] ? $pagination->getTotalItemCount() : 0,
            ];
        }

        // render
        return $this->render('records/records/players.html.twig', [
            'title' => 'Records :: Players',
            'pagination' => $pagination,
            'comm_list' => $comm_list,
        ]);
    }

    /**
     * @Route("/records/players/{comm}/{name}", name="records_player")
     */
    public function player(
        $comm = "xj",
        $name,
        Request $request,
        PaginatorInterface $paginator,
        InfiniteScrollService $infscr,
        RecordsModel $RecordsModel,
        TimesService $times
    )
    {
        // get request
        $page = $request->query->getInt('page', 1);

        // get player
        $player = $RecordsModel->getPlayer($name);
        if(!$player) { 
            throw $this->createNotFoundException(); 
        }

        // get demos
        $demos = $RecordsModel->getPlayerDemos($name, $comm);
        $pagination = $paginator->paginate($demos, $page, 20);

        // set demos vars
        $demos = $pagination->getItems();
        foreach ($demos as &$demo) {
            $demo += [
                'url_map' => "records/maps/{$comm}/{$demo['map']}",
                'timed' => $times->timed($demo['time'], 2),
            ];
        }
        $pagination->setItems($demos);

        // set infinite scroll
        $pagination = $infscr->setPaginationNext($pagination, $request);

        // Community
        $comm_info = $RecordsModel->getComms($comm);
        $comm_list = $RecordsModel->getPlayerComm($name);
        //!$comm && isset($comm_list[0]['name']) && $comm = $comm_list[0]['name'];

        // set community vars
        foreach ($comm_list as &$row) {
            $row += [
                'url_comm' => "records/players/{$row['name']}/{$player['player']}",
                'active' => $row['name']==$comm_info['name'] ? 'active' : '',
                'totals' => $row['name']==$comm_info['name'] ? $pagination->getTotalItemCount() : 0,
            ];
        }

        // render
        return $this->render('records/records/player.html.twig', [
            'title' => 'Records :: Player',
            'player' => $player,
            'pagination' => $pagination,
            'comm_list' => $comm_list,
        ]);
    }

    /**
     * @Route("/records/maps/{comm}", name="records_maps")
     */
    public function maps(
        $comm = 'xj',
        Request $request,
        PaginatorInterface $paginator,
        InfiniteScrollService $infscr,
        RecordsModel $RecordsModel
    )
    {
        // get request
        $page = $request->query->getInt('page', 1);

        // get maps
        $maps = $RecordsModel->getMaps($comm);
        $pagination = $paginator->paginate($maps, $page, 20);

        // set vars
        $maps = $pagination->getItems();
        foreach ($maps as &$map) {
            $map += [
                "url_download" => str_replace('%map%', $map["mapname"], $map["download"]),
                'url_map' => "records/maps/{$comm}/{$map['mapname']}",
            ];
        }
        $pagination->setItems($maps);

        // set infinite scroll
        $pagination = $infscr->setPaginationNext($pagination, $request);

        // Get community data
        $comm_info = $RecordsModel->getComms($comm);
        $comm_list = $RecordsModel->getComms();

        // set vars
        foreach ($comm_list as &$row) {
            $row += [
                'url_comm' => "records/maps/{$row['name']}",
                'active' => $row['name']==$comm_info['name'] ? 'active' : '',
                'totals' => $row['name']==$comm_info['name'] ? $pagination->getTotalItemCount() : 0,
            ];
        }

        // render
        return $this->render('records/records/maps.html.twig', [
            'title' => 'Records :: Maps',
            'pagination' => $pagination,
            'comm_list' => $comm_list,
        ]);
    }

    /**
     * @Route("/records/maps/{comm}/{map}", name="records_map")
     */
    public function map(
        $comm = 'xj',
        $map
    )
    {
        return $this->render('records/records/map.html.twig', [
            'title' => 'Records :: Map',
            'map' => $map,
        ]);
    }

    /**
     * @Route("/records/longjumps", name="records_longjumps")
     */
    public function longjumps(
        $comm = 'xj',
        RecordsModel $RecordsModel
    )
    {
        // get pages
        $pages = $RecordsModel->getLongjumpsPage();
        foreach ($pages as &$page) {
            $page += [
                'url_page' => "records/longjumps/{$page['name']}",
                'active' => $comm==$page['name'] ? 'active' : '',
            ];
        }

        // Get jumps
        $jumps = $RecordsModel->getLongjumps($comm);
        $lasttype = '';
        $head = 0;
        $num = 0;
        foreach ($jumps as $key => &$jump) {
            // Show Header
            $head = $lasttype!=$jump['type'] ? 1 : 0;
            $lasttype = $jump['type'];
            // Reset num on header
            $head && $num = 0;

            // Show footer
            $nexttype = isset($jumps[$key+1]['type']) ? $jumps[$key+1]['type'] : '';
            $foot = $nexttype!=$jump['type'] ? 1 : 0;

            // Sets
            $jump += [
                'head' => $head,
                'foot' => $foot,
                'cup_num' => ++$num,
            ];
        }
        

        return $this->render('records/records/longjumps.html.twig', [
            'title' => 'Records :: Longjumps',
            'pages' => $pages,
            'jumps'  => $jumps,
        ]);
    }

    /**
     * @Route("/records/compare/{comm}", name="records_compare")
     */
    public function compare(
        $comm = 'ru',
        Request $request,
        PaginatorInterface $paginator,
        InfiniteScrollService $infscr,
        RecordsModel $RecordsModel,
        TimesService $times
    )
    {
        // get request
        $page = $request->query->getInt('page', 1);

        // get maps
        $records = $RecordsModel->getCompare($comm);
        $pagination = $paginator->paginate($records, $page, 20);

        // set vars
        $records = $pagination->getItems();
        foreach ($records as &$record) {
            $record += [
                'url_map' => "records/maps/{$record['map']}",
                'wr_timed' => $times->timed($record["wr_time"], 2),
                'comm_timed' => $times->timed($record["comm_time"], 2),
                'top_timed' => $times->timed($record["top_time"], 2),
            ];
        }
        $pagination->setItems($records);

        // set infinite scroll
        $pagination = $infscr->setPaginationNext($pagination, $request);

        return $this->render('records/records/compare.html.twig', [
            'title' => 'Records :: Compare',
            'pagination' => $pagination,
        ]);
    }

}
