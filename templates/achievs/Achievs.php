<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Achievs extends MY_Controller
{
    public $lang;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('achievs_model', 'achievs');

        $this->lang = $this->config->item('language');
    }

    public function index($page = 1)
    {
        if(!is_numeric($page)) 
            show_404();

        // Get total rows
        $total = $this->achievs->count_achievs($this->lang);

        // Generate pagination
        $pag = $this->pagination->init([
            'base_url' => 'achievs',
            'total_rows' => $total,
            'uri_segment' => 1,
            'page' => $page,
        ]);

        // Get all rows and sets
        $achievs = $this->achievs->get_achievs($this->lang, $pag);
        foreach ($achievs as &$achiev) {
            $achiev += [
                'completer' => round($achiev["completed"], 2),
                'img_achiev' => $this->achievImg($achiev['aId']),
                'url_achiev' => "achievs/achiev/{$achiev['aId']}",
            ];
        }

        // Set data & pagination
        $this->render([
            'total' => $total,
            'achievs' => $achievs,
        ] + $pag);
    }

    public function achiev($id = 0, $page = 1)
    {
        if(!is_numeric($page) || !is_numeric($id)) 
            show_404();

        // Check achiev
        $achiev = $this->achievs->get_achiev($this->lang, $id);
        empty($achiev) && show_404();

        $achiev += [
            'img_achiev' => $this->achievImg($achiev['id']),
        ];

        // Get total rows
        $total = $this->achievs->count_achiev_players($id);

        // Generate pagination
        $pag = $this->pagination->init([
            'base_url' => "achievs/achiev/{$id}",
            'total_rows' => $total,
            'uri_segment' => 4,
            'page' => $page,
        ]);

        // Get all rows and sets
        $players = $this->achievs->get_achiev_players($id, $pag);
        foreach ($players as &$player) {
            Modules::run('Steam/getAvatar', $player, "avatarmedium");
            $player += [
                'img_player' => image("avatars/avatarmedium/{$player['id']}.jpg"),
                'url_player' => "achievs/player/{$player['id']}",
            ];
        }

        // Set data & pagination
        $this->render([
            'total' => $total,
            'players' => $players,
            'achiev' => [$achiev],
        ] + $pag);
    }

    public function players($page = 1)
    {
        if(!is_numeric($page)) 
            show_404();

        // Get total rows
        $total = $this->achievs->count_achievs_players();

        // Generate pagination
        $pag = $this->pagination->init([
            'base_url' => "achievs/players",
            'total_rows' => $total,
            'uri_segment' => 3,
            'page' => $page,
        ]);

        // Get all rows and sets
        $players = $this->achievs->get_achievs_players($pag);
        foreach ($players as &$player) {
            Modules::run('Steam/getAvatar', $player, "avatarmedium");
            $player += [
                'url_image' => image("avatars/avatarmedium/{$player['id']}.jpg"),
                'url_player' => "achievs/player/{$player['id']}",
            ];
        }

        /// Set data & pagination
        $this->render([
            'total' => $total,
            'players' => $players,
        ] + $pag);
    }

    public function player($id = null, $page = 1)
    {
        if(!is_numeric($page) || !is_numeric($id)) 
            show_404();

        // Get total rows
        $total = $this->achievs->count_achievs_player($this->lang, $id);

        // Generate pagination
        $pag = $this->pagination->init([
            'base_url' => "achievs/player/{$id}",
            'total_rows' => $total,
            'uri_segment' => 4,
            'page' => $page,
        ]);

        // Get total rows
        $achievs = $this->achievs->get_achievs_player($this->lang, $id, $pag);
        empty($achievs) && show_404();

        // Get all rows and sets
        foreach ($achievs as &$achiev) {
            if ($achiev["count"] != 1 && $achiev["count"] != $achiev["progress"]) {
                $achiev["width"] = $achiev["progress"] * 100 / $achiev["count"];
            }
            
            if ($achiev['count']==$achiev['progress']) {
                $achiev["achiev_completed"] = 'achiev_completed';
            }

            $achiev += [
                'img_achiev' => $this->achievImg($achiev['id']),
                'url_achiev' => "achievs/achiev/{$achiev['id']}",
                'isset_ahciev_width' => isset($achiev['width']),
            ];

            if (isset($achiev['unlocked'])) {
                $achiev['unlocked'] = date_format($achiev['unlocked'], "%d.%m.%Y %H:%M");
            }
        }

        // Set data & pagination
        $this->render([
            'total' => $total,
            'plname' => $achievs[0]['plname'],
            'achievs' => $achievs,
        ] + $pag);
    }

    private function achievImg($id)
    {
        return "http://gravatar.com/avatar/".md5($id)."?d=identicon";
    }
}
