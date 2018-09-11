<?php

namespace App\Controller\Kreedz;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\InfiniteScrollService;
use App\Service\TimesService;
use App\Model\KreedzModel;
use Knp\Component\Pager\PaginatorInterface;

class KreedzController extends AbstractController
{
    private $types = ['all', 'pro', 'nub'];

    /**
     * @Route("/kreedz/last", name="kreedz_last")
     */
    public function last(
        Request $request,
        PaginatorInterface $paginator,
        InfiniteScrollService $infscr,
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
                'url_map' => "kreedz/map/{$map['map']}",
                'url_player' => "kreedz/player/{$map['player']}",
                'timed' => $times->timed($map['time'], 5),
                'color_nogc' => !$map['go_cp'] ? 'green' : 'grey',
                'color_wpn' => ($map['wname']!='USP' && $map['wname']!='KNIFE') ? 'green' : 'grey',
                'map_admin' => 0,
            ];
        }
        $pagination->setItems($maps);

        // set infinite scroll
        $pagination = $infscr->setPaginationNext($pagination, $request);

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
        return $this->render('kreedz/kreedz/last.html.twig', [
            'title' => 'Kreedz :: Last',
            'pagination' => $pagination,
            'rtypes' => $rtypes,
        ]);
    }

        /**
     * @Route("/kreedz/players", name="kreedz_last")
     */
    public function players(
        Request $request,
        PaginatorInterface $paginator,
        InfiniteScrollService $infscr,
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
        $players = $KreedzModel->getPlayers($type, $search);
        $pagination = $paginator->paginate($players, $page, 20);

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

        // set infinite scroll
        $pagination = $infscr->setPaginationNext($pagination, $request);

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
        return $this->render('kreedz/kreedz/players.html.twig', [
            'title' => 'Kreedz :: Players',
            'pagination' => $pagination,
            'rtypes' => $rtypes,
            'search' => $search
        ]);
    }
}
