<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Steam extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        // load model
        $this->load->model('steam_model', 'steam');

        // load
        $this->load->library(['steamApi', 'form_validation']);

        // translation
        $this->lang->load(['auth', 'steam']);
    }

    public function index()
    {
        // get hauth steamid
        $storage = $this->session->userdata('HA::STORE');
        $huser = isset($storage['hauth_session.steam.user']) ? unserialize($storage['hauth_session.steam.user']) : '';

        // not logged
        if (!$huser)
            redirect('auth', 'refresh');

        // is logged -> back
        if (!$this->ion_auth->logged_in()) {
            // check steamid from db
            $user = $this->steam->get_user($huser->profile->identifier);

            // if user found
            if (isset($user->id)) {
                $ssuser = [
                    'user_id' => $user->id,
                    'identity' => $this->config->item('identity', 'ion_auth') == 'email' ? $user->email : $user->username,
                    'email' => $user->email,
                    'old_last_login' => $user->last_login,
                    'last_check' => (int) $user->last_login,
                ];

                // logged
                $this->session->set_userdata($ssuser);

                $this->ion_auth->_regenerate_session();

                redirect('/', 'refresh');
            }

            // back
            redirect('auth', 'refresh');
        }
        else {
            $user = $this->ion_auth->user()->row();
            $suser = $this->steamapi->getPlayerSummary($huser->profile->identifier);

            $puser = $this->steam->check_steamid($huser->profile->identifier);
            if (isset($puser->id)) {
                $cuser = $this->steam->get_steamid($user->email);
                if (isset($cuser->id)) {
                    $this->steam->merge_maptop($puser->id, $cuser->id);
                    $this->steam->upd_player_email($puser->id, $user->email);
                    $this->steam->del_player($cuser->id);
                }
            }
            
            $this->steam->set_steam($user->email, $suser->response->players[0]);
            $this->steam->set_steamid($user->email, $huser->profile->identifier);

            redirect('hauth/steam/profile', 'refresh');
        }
    }

    public function profile()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');
        }
        
        $act = $this->input->post('act');

        if ($act=='update') {
            redirect('hauth/window/Steam', 'refresh');
        }

        $user = $this->ion_auth->user()->row();
        $steaminfo = $this->steam->get_steamid($user->email);

        // is logged
        if (isset($steaminfo->steam_id_64) && $steaminfo->steam_id_64) {
            if($act=='delete') {
                $this->steam->del_steam($steaminfo->steam_id_64);
                $this->steam->del_steamid($user->email);
                redirect('hauth/steam/profile', 'refresh');
            }

            $steaminfo = $this->steam->get_steam($steaminfo->steam_id_64);
            if(isset($steaminfo->lastlogoff))
                $steaminfo->lastactive = gmdate("Y-m-d H:i:s", $steaminfo->lastlogoff);

        }

        $this->render($steaminfo);
    }

}
