<?php

namespace App\Controller\Servers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\CsServers;
use App\Service\SourceQueryService;
use App\Service\ImagesService;
use App\Model\ServersModel;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/servers", name="servers")
 */
class ServersController extends AbstractController
{
    /**
     * @Route("/", name="servers")
     */
    public function servers(
        Request $request,
        PaginatorInterface $paginator,
        ServersModel $ServersModel,
        SourceQueryService $sq
    )
    {
        // get request
        $search = $request->query->get('search');
        $page = $request->query->getInt('page', 1);

        // get result
        $servers = $ServersModel->findAll();
        $pagination = $paginator->paginate($servers, $page, 20);

        if($pagination->getPage() > $pagination->getPageCount()) {
            throw $this->createNotFoundException();
        }

        $servers = $pagination->getItems();
        foreach ($servers as &$server) {
            $update = strtotime($server['update']." ".date_default_timezone_get());
            $server = array_replace($server, [
                "update" => strftime("%d.%m %H:%M", $update),
                'url_addres' => "servers/{$server['id']}",
            ]);

            //$addr = explode(":",$server['addres']);
            //$server["ip"] = gethostbyname($addrs[0]);
            //$server['addr'] = gethostbyaddr($addr[0]);

            // Autoupdate
            // if (time()-$update > 1800) {
            //     $sq->Connect($server['addres']);
            //     $server += $sq->getInfo();
            // }
        }
        $pagination->setItems($servers);

        return $this->render('controller/servers/servers/servers.html.twig', [
            'title' => 'Servers',
            'pagination' => $pagination,
            'search' => $search,
        ]);
    }

    /**
     * @Route("/{id}", name="server", requirements={"id"="\d+"})
     */
    public function server(
        $id,
        ServersModel $ServersModel,
        SourceQueryService $sq,
        ImagesService $img
    )
    {
        $server = $ServersModel->find($id);

        if(!$server) { 
            throw $this->createNotFoundException(); 
        }

        $sq->Connect($server['addres']);
        $serverInfo = $sq->getInfo();
        $serverPlayers = $sq->getPlayers();

        $server += [
            'img_map' => $img->getImage("maps/{$server['map']}.jpg"),
        ];

        return $this->render('controller/servers/servers/server.html.twig', [
            'title' => 'Server :: '.$server['addres'],
            'server' => $server,
            'serverInfo' => $serverInfo,
            'serverPlayers' => $serverPlayers,
            'search' => '',
        ]);
    }

    /**
     * @Route("/find/", name="servers_find")
     */
    public function find(
        Request $request,
        SourceQueryService $sq,
        ImagesService $img
    )
    {
        $ip = $request->query->get('search');

        // get result
        $sq->Connect($ip);
        $serverInfo = $sq->getInfo();
        $serverPlayers = $sq->getPlayers();

        // set vars
        $server = [
            'img_map' => $img->getImage("maps/{$serverInfo['Map']}.jpg"),
        ];

        return $this->render('controller/servers/servers/server.html.twig', [
            'title' => 'Server :: '.$ip,
            'server' => $server,
            'serverInfo' => $serverInfo,
            'serverPlayers' => $serverPlayers,
            'search' => $ip,
        ]);
    }
}
