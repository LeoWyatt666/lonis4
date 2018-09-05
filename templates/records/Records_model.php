<?php
defined('BASEPATH') or exit('No direct script access allowed');

class records_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // Longjumps
    public function get_longjumps_page()
    {
        $sql = "SELECT `c`.`name`, `c`.`fullname` FROM `kz_ljs_recs` `r`
					LEFT JOIN `kz_comm` `c` ON `comm`=`c`.`name`
					GROUP BY `c`.`name` ORDER BY `c`.`sort`";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_longjumps_jumps($comm = 'xj')
    {
        $comm = $this->db->escape($comm);
        $sql  = "SELECT `r`.*, `t`.`fullname` `type_name`, `c`.`fullname` `comm_name` FROM `kz_ljs_recs` `r`
				LEFT JOIN `kz_ljs_type` `t` ON `type`=`t`.`name`
				LEFT JOIN `kz_comm` `c` ON `comm`=`c`.`name`
				WHERE `c`.`name` = {$comm} ORDER BY `c`.`sort`, `t`.`sort`, `block` DESC, `distance` DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function sql_records($comm)
    {
        $comm = $this->db->escape($comm);
        $sql = "SELECT `r1`.`map` `map`, `r1`.`mappath`,
			`r1`.`time` `wr_time`, `r1`.`player` `wr_player`, `r1`.`country` `wr_country`,
			`r2`.`time` `comm_time`, `r2`.`player` `comm_player`, `r2`.`country` `comm_country`,
			`t`.`time` `top_time`, `t`.`name` `top_player`
			FROM `kz_records` `r1`
				LEFT JOIN (SELECT * FROM `kz_records` WHERE comm= {$comm}) `r2` ON r1.map=r2.map AND r1.mappath=r2.mappath
				LEFT JOIN `kz_view_map_top1` `t` ON r1.map=t.map AND `go_cp` = 0
			WHERE (r1.comm='xj' OR r1.comm='cc' OR r1.comm IS NULL) ORDER BY `r1`.`map`";
        return $sql;
    }

    public function get_records($comm, $pag)
    {
        $sql = $this->sql_records($comm);
        $query = $this->db->query($sql." LIMIT {$pag['offset']}, {$pag['limit']}");
        return $query->result_array();
    }

    public function count_records($comm)
    {
        $sql = $this->sql_records($comm);
        return $this->db_count_all($sql);
    }

    // Maps
    public function sql_maps($comm)
    {
        $comm = $this->db->escape($comm);
        $sql = "SELECT `m`.`mapname`, `m`.`type`, `m`.`authors`, `m`.`date_old`,
						`c`.`download`, `d`.`dname`, `d`.`dcolor`, `d`.`icon`
				FROM `kz_map` `m`
					LEFT JOIN `kz_view_records` `r` ON `r`.`map` = `m`.`mapname`
					LEFT JOIN `kz_comm` `c` ON `c`.`name`=`r`.`comm`
					LEFT JOIN `kz_diff` `d` ON `d`.`id`=`m`.`diff`
				WHERE `r`.`comm` = {$comm}
				ORDER BY `m`.`mapname`";
        return $sql;
    }

    public function get_maps($comm, $pag)
    {
        $sql = $this->sql_maps($comm);
        $query = $this->db->query($sql." LIMIT {$pag['offset']}, {$pag['limit']}");
        return $query->result_array();
    }

    public function count_maps($comm)
    {
        $sql = $this->sql_maps($comm);
        return $this->db_count_all($sql);
    }

    // Demos
    public function sql_demos($comm)
    {
        $comm = $this->db->escape($comm);
        $sql = "SELECT `id`, `map`, `mappath`, `time`, `player`, `country`
				FROM kz_records WHERE `comm` = {$comm}";
        return $sql;
    }

    public function get_demos($comm, $pag)
    {
        $sql = $this->sql_demos($comm);
        $query = $this->db->query($sql." LIMIT {$pag['offset']}, {$pag['limit']}");
        return $query->result_array();
    }

    public function count_demos($comm)
    {
        $sql = $this->sql_demos($comm);
        return $this->db_count_all($sql);
    }

    // players
    public function sql_players($comm)
    {
        $comm = $this->db->escape($comm);
        $sql = "SELECT `player`, COUNT(*) `count` FROM kz_records `r`
				WHERE `comm` = {$comm} AND `time` IS NOT NULL
				GROUP BY `player` ORDER BY `count` DESC";
        return $sql;
    }

    public function get_players($comm, $pag)
    {
        $sql = $this->sql_players($comm);
        $query = $this->db->query($sql." LIMIT {$pag['offset']}, {$pag['limit']}");
        return $query->result_array();
    }

    public function count_players($comm)
    {
        $sql = $this->sql_players($comm);
        return $this->db_count_all($sql);
    }

    // player
    public function get_player($name)
    {
        $name = $this->db->escape($name);
        $sql = "SELECT * FROM kz_records WHERE `player` = {$name} LIMIT 1";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    // player community
    public function get_player_comm($name)
    {
        $name = $this->db->escape($name);
        $sql = "SELECT `name`, `fullname` FROM `kz_comm` `c`
					JOIN (SELECT `comm` FROM `kz_records`
							WHERE `player`={$name} GROUP BY `comm`) `cc`
					ON `c`.`name`=`cc`.`comm`
					ORDER BY `sort`";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    // players demos
    public function sql_player_demos($name, $comm)
    {
        $name = $this->db->escape($name);
        $comm = $this->db->escape($comm);
        $sql = "SELECT * FROM kz_records WHERE `player`={$name} AND `comm`={$comm}";
        return $sql;
    }

    public function get_player_demos($name, $comm, $pag)
    {
        $sql = $this->sql_player_demos($name, $comm);
        $query = $this->db->query($sql." LIMIT {$pag['offset']}, {$pag['limit']}");
        return $query->result_array();
    }

    public function count_player_demos($name, $comm)
    {
        $sql = $this->sql_player_demos($name, $comm);
        return $this->db_count_all($sql);
    }

    // Community
    public function get_comms()
    {
        $sql = "SELECT `name`, `fullname` FROM kz_comm ORDER BY `sort`";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_comm($comm)
    {
        $comm = $this->db->escape($comm);
        $sql = "SELECT `name`, `fullname` FROM kz_comm WHERE `name` = {$comm} ORDER BY `sort`";
        $query = $this->db->query($sql);
        return $query->row_array();
    }
}
