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
    private $types = ['all', 'pro', 'noob'];

    /**
     * @Route("/kreedz/last/{type}", name="kreedz_last")
     */
    public function last(
        $type = "all",
        Request $request,
        PaginatorInterface $paginator,
        InfiniteScrollService $infscr,
        KreedzModel $KreedzModel,
        TimesService $times
    )
    {
        if(!in_array($type, $this->types)) {
            throw $this->createNotFoundException();
        }

        // get request
        $page = $request->query->getInt('page', 1);

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
                'url' => "kreedz/last/{$ctype}",
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
}
