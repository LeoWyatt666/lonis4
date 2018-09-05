<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Records extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('records_model', 'records');

        $this->assets->add([
            "records/records.css",
        ], __CLASS__);
    }

    public function index()
    {
        $this->render();
    }
    
    //---------------------------------------------------------------------------------------------
    public function players($comm = 'xj', $page = 1)
    {
        if(!is_numeric($page))
            show_404();

        // Get total rows
        $total = $this->records->count_players($comm);

        // Get community data
        $comm_info = $this->records->get_comm($comm);
        $comm_list = $this->records->get_comms();
        foreach ($comm_list as &$row) {
            $row += [
                'url_comm' => "records/players/{$row['name']}",
                'active' => $row['name']==$comm_info['name'] ? 'active' : '',
                'totals' => $row['name']==$comm_info['name'] ? $total : 0,
            ];
        }

        // Generate pagination
        $pag = $this->pagination->init([
            'base_url' => "records/players/{$comm}",
            'total_rows' => $total,
            'uri_segment' => 4,
            'page' => $page,
        ]);

        // Get all rows and sets
        $players = $this->records->get_players($comm, $pag);
        foreach ($players as &$player) {
            $player += [
                'url_player' => "records/player/{$player['player']}",
                'cup_num' => $this->cup_num(++$pag['offset']),
            ];
        }

        // Render
        $this->render([
            'total' => $total,
            'players' => $players,
            'comm_info' => [$comm_info],
            'comm_list' => $comm_list,
        ] + $pag);
    }

    //---------------------------------------------------------------------------------------------
    public function player($name = '', $comm = '', $page = 1)
    {
        if(!is_numeric($page))
            show_404();

        // Encode URL + XSS
        $name = $this->security->xss_clean(urlencode($name));

        // Check player
        $player = $this->records->get_player($name);
        empty($player) && show_404();

        // Get community data and check
        $comm_list = $this->records->get_player_comm($name);
        !$comm && isset($comm_list[0]['name']) && $comm = $comm_list[0]['name'];

        // Get total rows
        $total = $this->records->count_player_demos($name, $comm);

        // Get community info
        $comm_info = $this->records->get_comm($comm);
        foreach ($comm_list as &$row) {
            $row += [
                'url_comm' => "records/player/{$player['player']}/{$row['name']}",
                'active' => $row['name']==$comm_info['name'] ? 'active' : '',
                'totals' => $row['name']==$comm_info['name'] ? $total : 0,
            ];
        }

        // Generate pagination
        $pag = $this->pagination->init([
            'base_url' => "records/player/{$name}/{$comm}",
            'total_rows' => $total,
            'uri_segment' => 5,
            'page' => $page,
        ]);

        // Get all rows and sets
        $demos = $this->records->get_player_demos($name, $comm, $pag);
        foreach ($demos as &$demo) {
            $demo += [
                'url_map' => "records/map/{$demo['map']}",
                'timed' => timed($demo['time'], 2),
            ];
        }
        
        // Render
        $this->render([
            'player' => [$player],
            'demos' => $demos,
            'total' => $total,
            'comm_info' => [$comm_info],
            'comm_list' => $comm_list,
        ] + $pag);
    }

    //---------------------------------------------------------------------------------------------
    public function demos($comm = 'xj', $page = 1)
    {
        if(!is_numeric($page))
            show_404();

        // Get total rows
        $total = $this->records->count_demos($comm);

        // Get community data
        $comm_list = $this->records->get_comms();
        $comm_info = $this->records->get_comm($comm);
        foreach ($comm_list as &$row) {
            $row += [
                'url_comm' => "records/demos/{$row['name']}",
                'active' => $row['name']==$comm_info['name'] ? 'active' : '',
                'totals' => $row['name']==$comm_info['name'] ? $total : 0,
            ];
        }

        // Generate pagination
        $pag = $this->pagination->init([
            'base_url' => "records/demos/{$comm}",
            'total_rows' => $total,
            'uri_segment' => 4,
            'page' => $page,
        ]);

        // Get all rows and sets
        $demos = $this->records->get_demos($comm, $pag);
        foreach ($demos as &$demo) {
            $demo += [
                'url_map' => "records/map/{$demo['map']}",
                'timed' => timed($demo['time'], 2),
                'url_player' => "records/player/{$demo['player']}",
            ];
        }

        // Render
        $this->render([
            'admin' => 0,
            'total' => $total,
            'demos' => $demos,
            'comm_info' => [$comm_info],
            'comm_list' => $comm_list,
        ] + $pag);
    }
    
    //---------------------------------------------------------------------------------------------
    public function maps($comm = 'xj', $page = 1)
    {
        if(!is_numeric($page))
            show_404();

        // Get total rows
        $total = $this->records->count_maps($comm);

        // Get community data
        $comm_info = $this->records->get_comm($comm);
        $comm_list = $this->records->get_comms();
        foreach ($comm_list as &$row) {
            $row += [
                'url_comm' => "records/maps/{$row['name']}",
                'active' => $row['name']==$comm_info['name'] ? 'active' : '',
                'totals' => $row['name']==$comm_info['name'] ? $total : 0,
            ];
        }

        // Generate pagination
        $pag = $this->pagination->init([
            'base_url' => "records/maps/{$comm}",
            'total_rows' => $total,
            'uri_segment' => 4,
            'page' => $page,
        ]);

        // Get all rows and sets
        $maps = $this->records->get_maps($comm, $pag);
        foreach ($maps as &$map) {
            $map += [
                "url_download" => str_replace('%map%', $map["mapname"], $map["download"]),
                'url_map' => "records/map/{$map['mapname']}",
            ];
        }

        // Render
        $this->render([
            'admin' => 0,
            'total' => $total,
            'maps' => $maps,
            'comm_info' => [$comm_info],
            'comm_list' => $comm_list,
        ] + $pag);
    }
    
    //---------------------------------------------------------------------------------------------
    public function map($map = '')
    {
        // Render
        $this->render([
            'map' => $map,
        ]);
    }
    
    //---------------------------------------------------------------------------------------------
    public function longjumps($comm = 'xj')
    {
        // Get pages
        $pages = $this->records->get_longjumps_page();
        foreach ($pages as &$page) {
            $page += [
                'url_page' => "records/longjumps/{$page['name']}",
                'active' => $comm==$page['name'] ? 'active' : '',
            ];
        }

        // Get jumps
        $jumps = $this->records->get_longjumps_jumps($comm);
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
                'cup_num' => $this->cup_num(++$num),
            ];
        }

        // Render
        $this->render([
            'pages' => $pages,
            'jumps'  => $jumps,
        ]);
    }
    
    //---------------------------------------------------------------------------------------------
    public function compare($page = 1)
    {
        if(!is_numeric($page))
            show_404();

        $comm = 'ru';

        // Get total rows
        $total = $this->records->count_records($comm);

        // Generate pagination
        $pag = $this->pagination->init([
            'base_url' => "records/compare",
            'total_rows' => $total,
            'uri_segment' => 3,
            'page' => $page,
        ]);

        // Get all rows and sets
        $records = $this->records->get_records($comm, $pag);
        foreach ($records as &$record) {
            $record += [
                'url_map' => "records/maps/{$record['map']}",
                'wr_timed' => timed($record["wr_time"], 2),
                'comm_timed' => timed($record["comm_time"], 2),
                'top_timed' => timed($record["top_time"], 2),
            ];
        }

        // Render
        $this->render([
            'admin' => 0,
            'total' => $total,
            'records' => $records,
        ] + $pag);
    }

    private function cup_num($num)
    {
        $cup_color = [1=>"gold", 2=>"saddlebrown", 3=>"silver"];
        return $num<4 ? '<i class="icon trophy" style="color: '.$cup_color[$num].';" title="'.$num.'"></i>' : $num;
    }
}
