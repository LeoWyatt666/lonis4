<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Steam_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_user($steamid)
    {
        $steamid = $this->db->escape($steamid);
        $sql = "SELECT `u`.*, `p`.`steam_id_64` FROM `ci_users` `u`
                JOIN `cs_players` `p` ON `p`.`email` = `u`.`email`
                WHERE `steam_id_64` = {$steamid} LIMIT 1";
        return $this->db->query($sql)->row();
    }

    public function check_steamid($steamid) 
    {
        $sql = "SELECT `id`, `steam_id_64` FROM `cs_players` WHERE `steam_id_64` = '{$steamid}' LIMIT 1";
        return $this->db->query($sql)->row();
    }

    public function check_name($name)
    {
        $name = $this->db->escape($name);
        $sql = "SELECT `id` FROM `ci_users` WHERE `username` = {$name} LIMIT 1";
        return $this->db->query($sql)->row();
    }

    public function find_name($name, &$i = 0)
    {
        $named = $name."(".(++$i).")";
        return !$this->check_name($name) ? $this->find_name($named, $i) : $named;
    }

    // Steams
    public function get_steam($steamid)
    {
        $sql = "SELECT * FROM `ci_steams` WHERE `steamid`='{$steamid}' LIMIT 1";
        return $this->db->query($sql)->row();
    }

    public function set_steam($userid, $suser)
    {
        $param = '';
        foreach ($suser as $key => $value) {
            $value = $this->db->escape($value);
            $param .= "`{$key}`={$value},";
        }
        $param = substr($param, 0, -1);

        $sql = "INSERT INTO `ci_steams` 
                    SET {$param} 
                    ON DUPLICATE KEY UPDATE {$param}";
        $this->db->query($sql);

        return $this->db->insert_id();
    }

    public function del_steam($steamid) 
    {
        $sql = "DELETE FROM `ci_steams` WHERE `steamid` = '{$steamid}'";
        $this->db->query($sql);
    }

    // Steamid
    public function get_steamid($email)
    {
        $sql = "SELECT `id`, `steam_id_64` FROM `cs_players` WHERE `email` = '{$email}' LIMIT 1";
        return $this->db->query($sql)->row();
    }

    public function set_steamid($email, $steamid)
    {  
        $sql = "UPDATE IGNORE `cs_players` SET `steam_id_64` = {$steamid} WHERE `email` = '{$email}'";
        $this->db->query($sql);
    }

    public function del_steamid($email) 
    {
        $sql = "UPDATE `cs_players` SET `steam_id_64` = NULL WHERE `email` = '{$email}'";
        $this->db->query($sql);
    }

    public function merge_maptop($pid, $cid)
    {  
        $sql = "UPDATE `kz_map_top` SET `player` = {$pid} WHERE `player` = {$cid}";
        $this->db->query($sql);

        $sql = "UPDATE `kz_map_top1` SET `player` = {$pid} WHERE `player` = {$cid}";
        $this->db->query($sql);
    }

    public function del_player($cid) 
    {
        $sql = "DELETE FROM `cs_players` WHERE `id` = '{$cid}'";
        $this->db->query($sql);
    }

    public function upd_player_email($pid, $email)
    {  
        $sql = "UPDATE `cs_players` SET `email` = '{$email}' WHERE `id` = {$pid}";
        $this->db->query($sql);
    }
}
