<?php
defined('BASEPATH') or exit('No direct script access allowed');

class kreedz_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // Duels
    public function sql_duels()
    {
        $sql = "SELECT `d`.*, `pl1`.`name` `name1`, `pl2`.`name` `name2` FROM `kz_duel` `d`
				LEFT JOIN `cs_players` `pl1` ON `pl1`.`id` = `player1`
				LEFT JOIN `cs_players` `pl2` ON `pl2`.`id` = `player2`";
        return $sql;
    }

    public function get_duels($pag)
    {
        $sql = $this->sql_duels();
        $query = $this->db->query($sql." LIMIT {$pag['offset']}, {$pag['per_page']}");
        return $query->result_array();
    }

    public function count_duels()
    {
        $sql = $this->sql_duels();
        return $this->db_count_all($sql);
    }

    // Maps
    public function sql_maps($type, $map)
    {
        $map = $this->db->escape_like_str($map);
        $where = $this->get_types($type);
        $where .= $map ? "AND `map` LIKE '%{$map}%' ESCAPE '!'" : '';
        $sql = "SELECT `t`.`map` `mapname`, `t`.* FROM `kz_view_map_top1` `t` WHERE 1 {$where} ORDER BY `map`";
        return $sql;
    }

    public function get_maps($type, $map, $pag)
    {
        $sql = $this->sql_maps($type, $map);
        $query = $this->db->query($sql." LIMIT {$pag['offset']}, {$pag['per_page']}");
        return $query->result_array();
    }

    public function count_maps($type, $map)
    {
        $sql = $this->sql_maps($type, $map);
        return $this->db_count_all($sql);
    }

    // Maps norec
    public function sql_maps_norec()
    {
        $sql = "SELECT t.*, m.mapname, m.type mtype FROM `kz_map` `m` 
					LEFT JOIN `kz_view_map_top1` `t` ON `t`.`map` = `m`.`mapname`
				WHERE `t`.`id` IS NULL ORDER By `mapname`";
        return $sql;
    }

    public function get_maps_norec($pag)
    {
        $sql = $this->sql_maps_norec();
        $query = $this->db->query($sql." LIMIT {$pag['offset']}, {$pag['per_page']}");
        return $query->result_array();
    }

    public function count_maps_norec()
    {
        $sql = $this->sql_maps_norec();
        return $this->db_count_all($sql);
    }

    // Check map
    public function check_map($map)
    {
        $map = $this->db->escape($map);
        $sql = "SELECT COUNT(DISTINCT `map`) FROM `kz_map_top` WHERE `map` = {$map}";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    // Map players
    public function sql_map_players($map, $type)
    {
        $where = $this->get_types($type);
        $map = $this->db->escape($map);
        $sql = "SELECT `t`.* FROM `kz_view_map_top` `t`
				JOIN (
					SELECT `map`, `player`, min(`time`) as `mtime` FROM `kz_view_map_top`
						WHERE `map` = {$map} GROUP BY `player` ) AS `tmp`
				ON `t`.`player` = `tmp`.`player` AND `t`.`time` = `tmp`.`mtime`
				WHERE 1 {$where} ORDER BY `time`";
        return $sql;
    }

    public function get_map_players($map, $type, $pag)
    {
        $sql = $this->sql_map_players($map, $type);
        $query = $this->db->query($sql." LIMIT {$pag['offset']}, {$pag['per_page']}");
        return $query->result_array();
    }

    public function count_map_players($map, $type)
    {
        $sql = $this->sql_map_players($map, $type);
        return $this->db_count_all($sql);
    }

    // Maps last
    public function sql_maps_last($type)
    {
        $where = $this->get_types($type);
        $sql = "SELECT * FROM `kz_view_map_top` WHERE 1 {$where} ORDER BY `time_add` DESC, `map`";
        return $sql;
    }

    public function get_maps_last($type, $pag)
    {
        $sql = $this->sql_maps_last($type);
        $query = $this->db->query($sql." LIMIT {$pag['offset']}, {$pag['per_page']}");
        return $query->result_array();
    }

    public function count_maps_last($type)
    {
        $sql = $this->sql_maps_last($type);
        return $this->db_count_all($sql);
    }

    // Map info
    public function get_mapinfo($map)
    {
        $map = $this->db->escape($map);
        $sql = "SELECT *, `type` `mtype` FROM `kz_map`
					LEFT JOIN `kz_comm` ON `comm`=`name`
					LEFT JOIN `kz_diff` `d` ON `d`.`id`=`diff`
				WHERE `mapname` = {$map} ORDER BY `mapname` LIMIT 1";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    // Records
    public function get_records($map)
    {
        $map = $this->db->escape($map);
        $sql = "SELECT * FROM `kz_records` `r`, `kz_comm` `c`
				WHERE `map` = {$map} AND `name` = `comm`
				ORDER BY `sort`, `mappath`";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    // players
    public function sql_players($type, $sort, $name)
    {
        $name = $this->db->escape_like_str($name);
        $where = $this->get_types($type);
        $where2 = $name ? " AND `name` LIKE '%{$name}%' ESCAPE '!'" : '';
        $sql = "SELECT `id`, `name`, `all`, `top1` FROM `cs_players` `p`
				JOIN (
					SELECT COUNT(DISTINCT `map`) as `all`, `player` FROM kz_view_map_top
					WHERE 1 {$where} GROUP BY `player`) as `t` ON `id` = `t`.`player`
				LEFT JOIN (
					SELECT COUNT(DISTINCT `map`) as `top1`, `player` FROM kz_view_map_top1
					WHERE 1 {$where} GROUP BY `player`) as `t1` ON `id` = `t1`.`player`
				WHERE 1 {$where2} AND `all`>50 ORDER BY `{$sort}` DESC, `name`";
        return $sql;
    }

    public function get_players($type, $sort, $name, $pag)
    {
        $sql = $this->sql_players($type, $sort, $name);
        $query = $this->db->query($sql." LIMIT {$pag['offset']}, {$pag['per_page']}");
        return $query->result_array();
    }

    public function count_players($type, $sort, $name)
    {
        $sql = $this->sql_players($type, $sort, $name);
        return $this->db_count_all($sql);
    }

    // player
    public function get_player($id)
    {
        $id = $this->db->escape($id);
        $sql= "SELECT `id`, `name`, `steam_id`, `steam_id_64`, `email` FROM `cs_players` WHERE `id` = {$id} LIMIT 1";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    // player maps
    public function sql_player_maps($id, $type)
    {
        $id = $this->db->escape($id);
        $where = $this->get_types($type);
        $sql = "SELECT `mts`.* FROM `kz_view_map_top` `mts`
				JOIN (
					SELECT `map`, min(`time`) `mtime` FROM `kz_view_map_top`
						WHERE `player` = {$id} GROUP BY `map` ORDER BY `map`) `mt`
					ON `mts`.`map`=`mt`.`map` AND `mts`.`time`=`mt`.`mtime`
					WHERE 1 {$where} ORDER BY `map`";
        return $sql;
    }

    public function get_player_maps($id, $type, $pag)
    {
        $sql = $this->sql_player_maps($id, $type);
        $query = $this->db->query($sql." LIMIT {$pag['offset']}, {$pag['per_page']}");
        return $query->result_array();
    }

    public function count_player_maps($id, $type)
    {
        $sql = $this->sql_player_maps($id, $type);
        return $this->db_count_all($sql);
    }

    // player top1
    public function sql_player_top1($id, $type)
    {
        $where = $this->get_types($type);
        $sql = "SELECT * FROM `kz_view_map_top1` WHERE `player` = '{$id}' {$where}";
        return $sql;
    }

    public function get_player_top1($id, $type, $pag)
    {
        $sql = $this->sql_player_top1($id, $type);
        $query = $this->db->query($sql." LIMIT {$pag['offset']}, {$pag['per_page']}");
        return $query->result_array();
    }

    public function count_player_top1($id, $type)
    {
        $sql = $this->sql_player_top1($id, $type);
        return $this->db_count_all($sql);
    }

    // player norec
    public function sql_player_norec($id)
    {
        $sql = "SELECT `m`.`mapname`, `m`.`type`, `t1`.`player`, `t1`.`name`, `t1`.`time`,
					   `t1`.`cp`, `t1`.`go_cp`, `t1`.`weapon`, `t1`.`wname`,
					   `t1`.`dname`, `t1`.`dcolor`, `t1`.`icon`
				FROM `kz_map` `m`
					LEFT JOIN `kz_view_map_top1` `t1` ON `t1`.`map` = `m`.`mapname`
				WHERE `mapname` NOT IN (
					SELECT DISTINCT `map` FROM `kz_map_top` WHERE `player` = '{$id}')";
        return $sql;
    }

    public function get_player_norec($id, $pag)
    {
        $sql = $this->sql_player_norec($id);
        $query = $this->db->query($sql." LIMIT {$pag['offset']}, {$pag['per_page']}");
        return $query->result_array();
    }

    public function count_player_norec($id)
    {
        $sql = $this->sql_player_norec($id);
        return $this->db_count_all($sql);
    }

    private function get_types($type)
    {
        $types = array(
            'pro' => 'AND (`go_cp` = 0 AND `pspeed` = 250 )',
            'noob' => 'AND (`go_cp` != 0 OR NOT `pspeed` = 250)',
            'all' => ''
        );
        return isset($types[$type]) ? $types[$type] : '';
    }
}
