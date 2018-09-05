<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_player($user)
    {
        $sql = "SELECT * FROM `cs_players` WHERE `email`='{$user->email}' LIMIT 1";

        return $this->db->query($sql)->row();
    }

    public function add_player($v)
    {
        $v = $this->db->escape($v);

        $sql = "INSERT `cs_players` 
                SET `name`= '{$v->name}',
                    `email`='{$v->email}',
                    `active`=1";
        $this->db->query($sql);
        return $this->db->insert_id();
    }

    public function check_name($name)
    {
        $name = $this->db->escape($name);

        $sql = "SELECT id FROM cs_players p WHERE p.name={$name}";
        return !!$this->db->query($sql)->row();
    }

    public function upd_player($v)
    {
        $v = $this->db->escape($v);

        $sql = "UPDATE `cs_players`
				SET `name`= '{$v->name}',
					`password` = '{$v->password}',
					`ip` = '{$v->ip}',
					`icq` = '{$v->icq}'
				WHERE `id`={$v->id}";
        $this->db->query($sql);

        return $this->db->insert_id();
    } 
}
