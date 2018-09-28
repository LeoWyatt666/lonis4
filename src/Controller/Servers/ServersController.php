<?php

namespace App\Controller\Servers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\CsServers;
use App\Service\ImagesService;
use App\Model\ServersModel;
use Knp\Component\Pager\PaginatorInterface;
use App\Library\CSMonitoring;

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
        CSMonitoring $csm
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
            // set vars
            $server += [
                'url_addres' => "servers/{$server['id']}",
            ];

            // set server info
            $serv = parse_url($server['addres']);
            $server['info'] = $csm->getServerInfo($serv['host'], $serv['port'], $error);
            if($error) {
                $server['info'] = [
                    'players_count' => 0,
                    'players_max' => 0,
                    'map' => '-',
                ];
            }
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
        CSMonitoring $csm,
        ImagesService $img
    )
    {
        $server = $ServersModel->find($id);

        if(!$server) { 
            throw $this->createNotFoundException(); 
        }

        // get result
        $serv = parse_url($server['addres']);
        $server['info'] = $csm->getServerInfo($serv['host'], $serv['port'], $error);

        return $this->render('controller/servers/servers/server.html.twig', [
            'title' => 'Server :: '.$server['addres'],
            'server' => $server,
            'search' => '',
        ]);
    }

    /**
     * @Route("/find/", name="servers_find")
     */
    public function find(
        Request $request,
        CSMonitoring $csm,
        ImagesService $img
    )
    {
        $ip = $request->query->get('search');
        
        // get result
        $serv = parse_url($ip);
        if(!isset($serv['host'])) {
            $serv['host'] = $serv['path'];
            $serv['port'] = 27015;
        }

        if (!preg_match(
            '/^(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}$/',
            $serv['host'])) {
                throw $this->createNotFoundException();
        }

        $server['info'] = $csm->getServerInfo($serv['host'], $serv['port'], $error) ?? [];

        return $this->render('controller/servers/servers/server.html.twig', [
            'title' => 'Server :: '.$ip,
            'server' => $server,
            'search' => $ip,
        ]);
    }
}
