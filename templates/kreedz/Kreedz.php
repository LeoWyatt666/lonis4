<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kreedz extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('kreedz_model', 'kreedz');

        $this->assets->add([
            "cs-guns/guns.css",
        ], 'Kreedz');
    }

    //---------------------------------------------------------------------------------------------
    public function index()
    {
        $this->render();
    }
    
    public function last($type = "all", $page = 1)
    {
        $types = ['all', 'pro', 'noob'];

        if(!is_numeric($page) || !in_array($type, $types)) 
            show_404();

        // Get total rows
        $total = $this->kreedz->count_maps_last($type);

        // Generate type menu
        foreach ($types as $ctype) {
            $rtypes[] = [
                'type' => $ctype,
                'caption' => ucfirst($ctype),
                'url' => "kreedz/last/{$ctype}",
                'active' => $ctype==$type ? 'active' : '',
                'totals' => $ctype==$type ? $total : 0,
            ];
        }

        // Generate pagination
        $pag = $this->pagination->init([
            'base_url' => "kreedz/last/{$type}",
            'total_rows' => $total,
            'uri_segment' => 4,
            'page' => $page,
        ]);

        // Get all rows and sets
        $maps = $this->kreedz->get_maps_last($type, $pag);
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
                'timed' => timed($map['time'], 5),
                'color_nogc' => !$map['go_cp'] ? 'green' : 'grey',
                'color_wpn' => ($map['wname']!='USP' && $map['wname']!='KNIFE') ? 'green' : 'grey',
                'map_admin' => 0,
            ];
        }

        // Render
        $this->render([
            'admin' => 0,
            'total' => $total,
            'type' => $type,
            'maps' => $maps,
            'types' => $rtypes,
        ] + $pag);
    }

    //---------------------------------------------------------------------------------------------
    public function players($type = 'all', $sort = 'all', $page = 1)
    {
        $types = ['all', 'pro', 'noob'];
        $sortes = ['all', 'top1'];
        
        if(!is_numeric($page) || !in_array($type, $types) || !in_array($sort, $sortes))
            show_404();

        // Get search query
        $query = $this->input->get_post('q');
        // XSS
        $query = $this->security->xss_clean($query);

        // Get total rows
        $total = $this->kreedz->count_players($type, $sort, $query);

        // Generate type menu
        foreach ($types as $ctype) {
            $rtypes[] = [
                'type' => $ctype,
                'caption' => ucfirst($ctype),
                'url' => "kreedz/players/{$ctype}/{sort}{search}",
                'active' => $ctype==$type ? 'active' : '',
                'totals' => $ctype==$type ? $total : 0,
            ];
        }

        // Generate pagination
        $pag = $this->pagination->init([
            'base_url' => "kreedz/players/{$type}/{$sort}",
            'total_rows' => $total,
            'uri_segment' => 5,
            'page' => $page,
        ]);

        // Get all rows and sets
        $players = $this->kreedz->get_players($type, $sort, $query, $pag);
        foreach ($players as &$player) {
            $player += [
                'url_player' => "kreedz/player/{$player['id']}",
                'cup_num' => $this->cup_num(++$pag['offset']),
            ];
        }

        // Search query url
        $search = $query ? '?'.http_build_query(['q'=>$query]) : '';

        // Render
        $this->render([
            'total' => $total,
            'players' => $players,
            'search' => $search,
            'type' => $type,
            'sort' => $sort,
            'query' => $query,
            'url_all' => "kreedz/players/{$type}/all{$search}",
            'url_top1' => "kreedz/players/{$type}/top1{$search}",
            'types' => $rtypes,
        ] + $pag);
    }

    //---------------------------------------------------------------------------------------------
    public function player($id = 0, $type = 'all', $sort = 'all', $page = 1)
    {
        $types = ['all', 'pro', 'noob'];
        $sortes = ['all', 'top1'];
        
        if(!is_numeric($id) && !is_numeric($page) || !in_array($type, $types) || !in_array($sort, $sortes))
            show_404();

        // Check player
        $player = $this->kreedz->get_player($id);
        empty($player) && show_404();

        // Get total rows
        $total['all'] = $this->kreedz->count_player_maps($id, $type);
        $total['top1'] = $this->kreedz->count_player_top1($id, $type);

        // Generate type menu
        foreach ($types as $ctype) {
            $rtypes[] = [
                'type' => $ctype,
                'caption' => ucfirst($ctype),
                'url' => "kreedz/player/{$id}/{$ctype}/{$sort}",
                'active' => $ctype==$type ? 'active' : '',
                'totals' => $ctype==$type ? $total[$sort] : 0,
            ];
        }

        // Generate sort menu
        foreach ($sortes as $csort) {
            $rsortes[] = [
                'sort' => $csort,
                'caption' => ucfirst($csort),
                'url' => "kreedz/player/{$id}/{$type}/{$csort}",
                'active' => $csort==$sort ? 'active' : '',
            ];
        }

        // Generate pagination
        $pag = $this->pagination->init([
            'base_url' => "kreedz/player/{$id}/{$type}/{$sort}",
            'total_rows' => $total[$sort],
            'uri_segment' => 6,
            'page' => $page,
        ]);

        // Get all rows and sets
        $maps = $sort=='all'
              ? $this->kreedz->get_player_maps($id, $type, $pag)
              : $this->kreedz->get_player_top1($id, $type, $pag);
        foreach ($maps as &$map) {
            $map += [
                'url_map' => "kreedz/map/{$map['map']}",
                'url_player' => "kreedz/player/{$map['player']}",
                'timed' => timed($map['time'], 5),
                'color_nogc' => !$map['go_cp'] ? 'green' : 'grey',
                'color_wpn' => ($map['wname']!='USP' && $map['wname']!='KNIFE') ? 'green' : 'grey',
                'map_admin' => 0,
            ];
        }

        // Render
        $this->render([
            'admin' => 0,
            'type' => $type,
            'sort' => $sort,
            'player_name' => $player['name'],
            'maps' => $maps,
            'total' => $total[$sort],
            'types' => $rtypes,
            'sortes' => $rsortes,
            'url_norec' => "kreedz/player_norec/{$player['id']}",
        ] + $pag);
    }

    //---------------------------------------------------------------------------------------------
    public function player_norec($id = null, $page = 1)
    {
        if(!is_numeric($id) && !is_numeric($page))
            show_404();

        // Check player
        $player = $this->kreedz->get_player($id);
        empty($player) && show_404();

        // Get total rows
        $total = $this->kreedz->count_player_norec($id);

        // Generate pagination
        $pag = $this->pagination->init([
            'base_url' => "kreedz/player_norec/{$id}",
            'total_rows' => $total,
            'uri_segment' => 5,
            'page' => $page,
        ]);

        // Get all rows and sets
        $maps = $this->kreedz->get_player_norec($id, $pag);
        foreach ($maps as &$map) {
            $map += [
                'url_map' => "kreedz/map/{$map['mapname']}",
                'url_player' => "kreedz/player/{$map['player']}",
                'timed' => timed($map['time'], 5),
                'color_nogc' => !$map['go_cp'] ? 'green' : 'grey',
                'color_wpn' => ($map['wname']!='USP' && $map['wname']!='KNIFE') ? 'green' : 'grey',
                'map_admin' => 0,
            ];
        }

        // Render
        $this->render([
            'admin' => 0,
            'player_name' => $player['name'],
            'player_id' => $player['id'],
            'total' => $total,
            'maps' => $maps,
        ] + $pag);
    }

    //---------------------------------------------------------------------------------------------
    public function maps($type = 'all', $page = 1)
    {
        $types = ['all', 'pro', 'noob'];
        
        if(!is_numeric($page) || !in_array($type, $types))
            show_404();

        // Get search query
        $query = $this->input->get_post('q');

        // XSS
        $query = $this->security->xss_clean($query);

        // Get total rows
        $total = $this->kreedz->count_maps($type, $query);

        // Generate type menu
        foreach ($types as $ctype) {
            $rtypes[] = [
                'type' => $ctype,
                'caption' => ucfirst($ctype),
                'url' => "kreedz/maps/{$ctype}/{sort}{search}",
                'active' => $ctype==$type ? 'active' : '',
                'totals' => $ctype==$type ? $total : 0,
            ];
        }

        // Generate pagination
        $pag = $this->pagination->init([
            'base_url' => "kreedz/maps/{$type}",
            'total_rows' => $total,
            'uri_segment' => 4,
            'page' => $page,
        ]);

        // Get all rows and sets
        $maps = $this->kreedz->get_maps($type, $query, $pag);
        foreach ($maps as &$map) {
            $map += [
                'url_map' => "kreedz/map/{$map['map']}",
                'url_player' => "kreedz/player/{$map['player']}",
                'timed' => timed($map['time'], 5),
                'color_nogc' => !$map['go_cp'] ? 'green' : 'grey',
                'color_wpn' => ($map['wname']!='USP' && $map['wname']!='KNIFE') ? 'green' : 'grey',
                'map_admin' => 0,
            ];
        }

        // Search query url
        $search = $query ? '?'.http_build_query(['q'=>$query]) : '';

        // Render
        $this->render([
            'admin' => 0,
            'total' => $total,
            'type' => $type,
            'maps' => $maps,
            'query' => $query,
            'search' => $search,
            'types' => $rtypes,
        ] + $pag);
    }

    //---------------------------------------------------------------------------------------------
    public function maps_norec($page = 1)
    {
        if(!is_numeric($page))
            show_404();

        // Get total rows
        $total = $this->kreedz->count_maps_norec();

        // Generate pagination
        $pag = $this->pagination->init([
            'base_url' => "kreedz/maps_norec",
            'total_rows' => $total,
            'uri_segment' => 4,
            'page' => $page,
            'per_page' => 30,
        ]);

        // Get all rows and sets
        $maps = $this->kreedz->get_maps_norec($pag);
        foreach ($maps as &$map) {
            $map += [
                'img_map' => image("maps/{$map['mapname']}.jpg"),
            ];
        }

        // Render
        $this->render([
            'admin' => 0,
            'maps' => $maps,
            'total' => $total,
        ] + $pag);
    }

    //---------------------------------------------------------------------------------------------
    public function map($map = null, $type = 'all', $page = 1)
    {
        $types = ['all', 'pro', 'noob'];
        
        if(!empty($id) && !is_numeric($page) || !in_array($type, $types))
            show_404();
            
        // Check maps
        $check = $this->kreedz->check_map($map);
        empty($check) && show_404();

        // Get Mapinfo
        $mapinfo = $this->kreedz->get_mapinfo($map);

        // Map Records
        $maprec = $this->kreedz->get_records($map);
        $lastcomm = "";
        foreach ($maprec as &$rec) {
            $rec += [
                'uname' => strtoupper($rec['name']),
                'part' => $rec["comm"]==$lastcomm ? 0 : 1,
                'timed' => timed($rec["time"], 2),
            ];
            $lastcomm = $rec["comm"];
        }

        // Get total rows
        $total = $this->kreedz->count_map_players($map, $type);

        // Generate type menu
        foreach ($types as $ctype) {
            $rtypes[] = [
                'type' => $ctype,
                'caption' => ucfirst($ctype),
                'url' => "kreedz/map/{$map}/{$ctype}",
                'active' => $ctype==$type ? 'active' : '',
                'totals' => $ctype==$type ? $total : 0,
            ];
        }

        // Generate pagination
        $pag = $this->pagination->init([
            'base_url' => "kreedz/map/{$map}/{$type}",
            'total_rows' => $total,
            'uri_segment' => 5,
            'page' => $page,
        ]);

        // Get all rows and sets
        $players = $this->kreedz->get_map_players($map, $type, $pag);
        foreach ($players as &$player) {
            $player += [
                'url_map' => "kreedz/map/{$player['map']}",
                'url_player' => "kreedz/player/{$player['player']}",
                'timed' => timed($player['time'], 5),
                'color_nogc' => !$player['go_cp'] ? 'green' : 'grey',
                'color_wpn' => ($player['wname']!='USP' && $player['wname']!='KNIFE') ? 'green' : 'gray',
                'cup_num' => $this->cup_num(++$pag['offset']),
            ];
        }

        // Render
        $this->render([
            'total' => $total,
            'map' => $map,
            'type' => $type,
            'players' => $players,
            'maprec' => $maprec,
            'mapinfo' => [$mapinfo],
            'types' => $rtypes,
            'img_map' => image('maps/{$map}.jpg'),
        ] + $pag);
    }

    //---------------------------------------------------------------------------------------------
    public function duels($page = 1)
    {
        if(!is_numeric($page))
            show_404();

        // Get total rows
        $total = $this->kreedz->count_duels();

        // Generate pagination
        $pag = $this->pagination->init([
            'base_url' => "kreedz/duels",
            'total_rows' => $total,
            'uri_segment' => 3,
            'page' => $page,
        ]);

        // Get all rows and sets
        $duels = $this->kreedz->get_duels($pag);
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
                'url_map' => "kreedz/map/{$duel['map']}",
                'url_winner' => "kreedz/player/{$duel['winnerId']}",
                'url_looser' => "kreedz/player/{$duel['looserId']}",
            ];
        }

        // Render
        $this->render([
            'total' => $total,
            'duels' => $duels,
        ] + $pag);
    }

    //---------------------------------------------------------------------------------------------
    public function longjumps()
    {
        //".($admin ? '?form_admin=1'
        $this->render([
            'url_ljstats' => "common/ljstats/index.php",
        ]);
    }

    private function cup_num($num)
    {
        $cup_color = [1=>"gold", 2=>"saddlebrown", 3=>"silver"];
        return $num<4 ? '<i class="icon trophy" style="color: '.$cup_color[$num].';" title="'.$num.'"></i>' : $num;
    }
}
