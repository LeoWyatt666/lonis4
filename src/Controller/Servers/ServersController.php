<?php

namespace App\Controller\Servers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\CsServers;
use App\Service\InfiniteScrollService;
use App\Service\HldsService;
use App\Model\ServersModel;
use Knp\Component\Pager\PaginatorInterface;

class ServersController extends AbstractController
{
    /**
     * @Route("/servers", name="servers")
     */
    public function servers(
        Request $request,
        PaginatorInterface $paginator,
        InfiniteScrollService $infscr,
        ServersModel $ServersModel
    )
    {
        // get request
        $search = $request->query->get('search');
        $page = $request->query->getInt('page', 1);

        // get result
        $servers = $ServersModel->findAll();
        $pagination = $paginator->paginate($servers, $page, 20);

        // set infinite scroll
        $pagination = $infscr->setPaginationNext($pagination, $request);

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
            //     $server = $this->servers->get_servers_info($server);
            //     $this->servers->set_servers($server);
            // }
        }
        $pagination->setItems($servers);

        return $this->render('servers/servers/servers.html.twig', [
            'title' => 'Servers',
            'pagination' => $pagination,
            'search' => $search,
        ]);
    }

    /**
     * @Route("/servers/{id}", name="server", requirements={"id"="\d+"})
     */
    public function server(
        $id,
        ServersModel $ServersModel,
        HldsService $hlds
    )
    {
        $server = $ServersModel->find($id);
        $server += $hlds->getServerInfo($server['addres'], true);

        $server += [
            'img_map' => "images/maps/{$server['map']}.jpg",
            'ip' => $server['addres'],
        ];

        return $this->render('servers/servers/server.html.twig', [
            'title' => 'Server',
            'server' => $server,
            'search' => '',
        ]);
    }

    /**
     * @Route("/servers/find/", name="servers_find")
     */
    public function find(
        Request $request,
        HldsService $hlds
    )
    {
        $ip = $request->query->get('search');

        // get result
        $server = $hlds->getServerInfo($ip, true);

        // set vars
        if ($server) {
            $server += [
                'img_map' => "images/maps/{$server['map']}.jpg",
                'ip' => $ip,
                'modname' => $server['mod'],
            ];
        }

        return $this->render('servers/servers/server.html.twig', [
            'title' => 'Server',
            'server' => $server,
            'search' => $ip,
        ]);
    }
}