<?php

namespace App\Controller\Records;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\KzRecords;
use App\Service\TimesService;
use App\Model\RecordsModel;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/records", name="records_")
 */
class RecordsController extends AbstractController
{
    /**
     * @Route("/demos/{comm}", name="demos")
     */
    public function demos(
        $comm = 'xj',
        Request $request,
        PaginatorInterface $paginator,
        RecordsModel $RecordsModel,
        TimesService $times
    )
    {
        // get request
        $page = $request->query->getInt('page', 1);

        // get players
        $demos = $RecordsModel->getDemos($comm);
        $pagination = $paginator->paginate($demos, $page, 20);

        if($pagination->getPage() > $pagination->getPageCount()) {
            throw $this->createNotFoundException();
        }

        // set vars
        $demos = $pagination->getItems();
        foreach ($demos as &$demo) {
            $demo += [
                'timed' => $times->timed($demo['time'], 2),
            ];
        }
        $pagination->setItems($demos);

        // Get community data
        $comm_info = $RecordsModel->getComms($comm);
        $comm_list = $RecordsModel->getComms();

        return $this->render('controller/records/records/demos.html.twig', [
            'title' => 'Demos',
            'pagination' => $pagination,
            'comm_list' => $comm_list,
            'comm_info' => $comm_info,
        ]);
    }

    /**
     * @Route("/players/{comm}", name="players")
     */
    public function players(
        $comm = "xj",
        Request $request,
        PaginatorInterface $paginator,
        RecordsModel $RecordsModel
    )
    {
        // get request
        $page = $request->query->getInt('page', 1);

        // get players
        $players = $RecordsModel->getPlayers($comm);
        $pagination = $paginator->paginate($players, $page, 20);

        if($pagination->getPage() > $pagination->getPageCount()) {
            throw $this->createNotFoundException();
        }

        // set cup nums
        $cup_num = ($page-1)*$pagination->getItemNumberPerPage();
        
        // Get community data
        $comm_info = $RecordsModel->getComms($comm);
        $comm_list = $RecordsModel->getComms();

        // render
        return $this->render('controller/records/records/players.html.twig', [
            'title' => 'Records :: Players',
            'pagination' => $pagination,
            'comm_list' => $comm_list,
            'comm_info' => $comm_info,
            'comm' => $comm,
            'cup_num' => $cup_num,
        ]);
    }

    /**
     * @Route("/players/{comm}/{name}", name="player")
     */
    public function player(
        $comm = "xj",
        $name,
        Request $request,
        PaginatorInterface $paginator,
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

        if($pagination->getPage() > $pagination->getPageCount()) {
            throw $this->createNotFoundException();
        }

        // set demos vars
        $demos = $pagination->getItems();
        foreach ($demos as &$demo) {
            $demo += [
                'timed' => $times->timed($demo['time'], 2),
            ];
        }
        $pagination->setItems($demos);

        // Community
        $comm_info = $RecordsModel->getComms($comm);
        $comm_list = $RecordsModel->getPlayerComm($name);

        // render
        return $this->render('controller/records/records/player.html.twig', [
            'title' => 'Records :: Player',
            'player' => $player,
            'pagination' => $pagination,
            'comm_list' => $comm_list,
            'comm_info' => $comm_info,
        ]);
    }

    /**
     * @Route("/maps/{comm}", name="maps")
     */
    public function maps(
        $comm = 'xj',
        Request $request,
        PaginatorInterface $paginator,
        RecordsModel $RecordsModel
    )
    {
        // get request
        $page = $request->query->getInt('page', 1);

        // get maps
        $maps = $RecordsModel->getMaps($comm);
        $pagination = $paginator->paginate($maps, $page, 20);

        if($pagination->getPage() > $pagination->getPageCount()) {
            throw $this->createNotFoundException();
        }

        // Get community data
        $comm_info = $RecordsModel->getComms($comm);
        $comm_list = $RecordsModel->getComms();

        // render
        return $this->render('controller/records/records/maps.html.twig', [
            'title' => 'Records :: Maps',
            'pagination' => $pagination,
            'comm_list' => $comm_list,
            'comm_info' => $comm_info,
        ]);
    }

    /**
     * @Route("/map/{map}", name="map")
     */
    public function map(
        $map,
        RecordsModel $RecordsModel,
        TimesService $times
    )
    {
        // Get Mapinfo
        $mapinfo = $RecordsModel->getMapInfo($map);

        // Map Records
        $maprec = $RecordsModel->getRecords($map);
        foreach ($maprec as &$rec) {
            $rec += [
                'timed' => $times->timed($rec["time"], 2),
            ];
        }

        return $this->render('controller/records/records/map.html.twig', [
            'title' => 'Records :: Map :: '.$map,
            'mapinfo' => $mapinfo,
            'maprec' => $maprec,
        ]);
    }

    /**
     * @Route("/longjumps/{comm}", name="longjumps")
     */
    public function longjumps(
        $comm = 'xj',
        RecordsModel $RecordsModel
    )
    {
        // get pages
        $pages = $RecordsModel->getLongjumpsPage();

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
        

        return $this->render('controller/records/records/longjumps.html.twig', [
            'title' => 'Records :: Longjumps',
            'pages' => $pages,
            'jumps'  => $jumps,
            'comm' => $comm,
        ]);
    }

    /**
     * @Route("/compare/{comm}", name="compare")
     */
    public function compare(
        $comm = 'ru',
        Request $request,
        PaginatorInterface $paginator,
        RecordsModel $RecordsModel,
        TimesService $times
    )
    {
        // get request
        $page = $request->query->getInt('page', 1);

        // get maps
        $records = $RecordsModel->getCompare($comm);
        $pagination = $paginator->paginate($records, $page, 20);

        if($pagination->getPage() > $pagination->getPageCount()) {
            throw $this->createNotFoundException();
        }

        // set vars
        $records = $pagination->getItems();
        foreach ($records as &$record) {
            $record += [
                'wr_timed' => $times->timed($record["wr_time"], 2),
                'comm_timed' => $times->timed($record["comm_time"], 2),
                'top_timed' => $times->timed($record["top_time"], 2),
            ];
        }
        $pagination->setItems($records);

        return $this->render('controller/records/records/compare.html.twig', [
            'title' => 'Records :: Compare',
            'pagination' => $pagination,
        ]);
    }

}
