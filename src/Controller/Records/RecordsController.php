<?php

namespace App\Controller\Records;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\KzRecords;
use App\Service\InfiniteScrollService;
use App\Model\RecordsModel;
use Knp\Component\Pager\PaginatorInterface;

class RecordsController extends AbstractController
{
    /**
     * @Route("/records/demos", name="records_demos")
     */
    public function demos()
    {
        return $this->render('records/records/demos.html.twig', [
            'title' => 'Demos',
        ]);
    }

    /**
     * @Route("/records/demos/{id}", name="records_demo")
     */
    public function demo(
        $id
    )
    {
        return $this->render('records/records/demo.html.twig', [
            'title' => 'Demo',
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

        $players = $RecordsModel->getPlayers($comm);
        $pagination = $paginator->paginate($players, $page, 20);

        // set infinite scroll
        $pagination = $infscr->setPaginationNext($pagination, $request);

        $cup_num = ($page-1)*20;
        
        $players = $pagination->getItems();
        foreach ($players as &$player) {
            $player += [
                'url_player' => "records/player/{$player['player']}",
                'cup_num' => ++$cup_num,
            ];
        }
        $pagination->setItems($players);

        // Get community data
        $comm_info = $RecordsModel->getComms($comm);
        $comm_list = $RecordsModel->getComms();

        foreach ($comm_list as &$row) {
            $row += [
                'url_comm' => "records/players/{$row['name']}",
                'active' => $row['name']==$comm_info['name'] ? 'active' : '',
                'totals' => $row['name']==$comm_info['name'] ? $pagination->getTotalItemCount() : 0,
            ];
        }

        //dump($pagination);

        return $this->render('records/records/players.html.twig', [
            'title' => 'Records :: Players',
            'pagination' => $pagination,
            'comm_list' => $comm_list,
        ]);
    }

    /**
     * @Route("/records/players/{comm}/{id}", name="records_player")
     */
    public function player(
        $comm = "xj",
        $id
    )
    {
        return $this->render('records/records/player.html.twig', [
            'title' => 'Player',
        ]);
    }

    /**
     * @Route("/records/maps", name="records_maps")
     */
    public function maps()
    {
        return $this->render('records/records/maps.html.twig', [
            'title' => 'Maps',
        ]);
    }

    /**
     * @Route("/records/maps/{id}", name="records_map")
     */
    public function map(
        $id
    )
    {
        return $this->render('records/records/maps.html.twig', [
            'title' => 'Map',
        ]);
    }

    /**
     * @Route("/records/compare", name="records_compare")
     */
    public function compare()
    {
        return $this->render('records/records/compare.html.twig', [
            'title' => 'Compare',
        ]);
    }

    /**
     * @Route("/records/longjumps", name="records_longjumps")
     */
    public function longjumps()
    {
        return $this->render('records/records/longjumps.html.twig', [
            'title' => 'Longjumps',
        ]);
    }

}
