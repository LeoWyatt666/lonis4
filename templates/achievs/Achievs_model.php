<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Achievs_model extends MY_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    // player Achievs
    public function sql_player_achievs($id)
    {
        $sql = "SELECT COUNT(*) as `achievCompleted` FROM `ac_achievs_players`, `ac_achievs`
					WHERE `achievId` = `id` AND `count` = `progress` AND `playerId` = {$id}";
        return $sql;
    }

    public function count_player_achievs($id)
    {
        $sql = $this->sql_player_achievs($id);
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    // Achievs players
    public function sql_achievs_players()
    {
        $sql = "SELECT steam_id_64, email, `id`, `name`,
					(SELECT COUNT(*) `achiev_total` FROM `ac_achievs_players` `pa`, `ac_achievs` `a`
						WHERE `achievId` = `a`.`id` AND `count` = `progress` AND `playerId` = `p`.`id`) AS `achiev_total`
					FROM `cs_players` `p`
					HAVING `achiev_total` > 0 ORDER BY `achiev_total` DESC";
        return $sql;
    }

    public function get_achievs_players($pag)
    {
        $sql = $this->sql_achievs_players();
        $query = $this->db->query($sql." LIMIT {$pag['offset']}, {$pag['per_page']}");
        return $query->result_array();
    }

    public function count_achievs_players()
    {
        $sql = $this->sql_achievs_players();
        return $this->db_count_all($sql);
    }

    // Achievs player
    public function sql_achievs_player($lang, $id)
    {
        $sql = "SELECT `icon`, `a`.`id`, `a`.`name`, `a`.`desc`, `count`,
					IF(`progress` IS NULL, 0, `progress`) AS `progress`,
					`p`.`name` as `plname`
				FROM `ac_view_achievs_list` `a`
				LEFT JOIN `ac_achievs_players` `pa` ON `pa`.`achievId` = `a`.`id`
				LEFT JOIN `cs_players` `p` ON `pa`.`playerId` = `p`.`id`
				WHERE `a`.`lang`='{$lang}' AND `p`.`id` = '{$id}'
				ORDER BY `progress` = `count` DESC, `progress`/`count` DESC";
        return $sql;
    }

    public function get_achievs_player($lang, $id, $pag)
    {
        $sql = $this->sql_achievs_player($lang, $id);
        $query = $this->db->query($sql." LIMIT {$pag['offset']}, {$pag['per_page']}");
        return $query->result_array();
    }

    public function count_achievs_player($lang, $id)
    {
        $sql = $this->sql_achievs_player($lang, $id);
        return $this->db_count_all($sql);
    }

    // Achievs
    public function sql_achievs($lang)
    {
        $sql = "SELECT `icon`, `id` AS `aId`, `name`, `desc`,
				(SELECT COUNT(*) FROM `ac_achievs` `a`, `ac_achievs_players` `ap`
				JOIN (SELECT @playerCount := (SELECT COUNT(*) FROM `cs_players`)) `player_count`
				WHERE `ap`.`achievId` = `a`.`id`
					AND `a`.`count` = `ap`.`progress`
					AND `ap`.`achievId` = `aId`)/@playerCount*100 AS `completed`
				FROM `ac_view_achievs_list` WHERE `lang`='{$lang}' ORDER BY `completed` DESC";
        return $sql;
    }

    public function get_achievs($lang, $pag)
    {
        $sql = $this->sql_achievs($lang);
        $query = $this->db->query($sql." LIMIT {$pag['offset']}, {$pag['per_page']}");
        return $query->result_array();
    }

    public function count_achievs($lang)
    {
        $sql = $this->sql_achievs($lang);
        return $this->db_count_all($sql);
    }

    // Achiev
    public function sql_achiev($lang, $id)
    {
        $sql = "SELECT `id`, `name`, `desc` FROM `ac_view_achievs_list` WHERE `lang`='{$lang}' AND `id` = {$id} LIMIT 1";
        return $sql;
    }

    public function get_achiev($lang, $id)
    {
        $sql = $this->sql_achiev($lang, $id);
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    // Achiev players
    public static function sql_achiev_players($id)
    {
        $sql = "SELECT p.steam_id_64, p.email, `p`.`id`, `p`.`name` AS `plname`,
				(SELECT COUNT(*) FROM `ac_achievs_players` `ap`, `ac_achievs` `a`
					WHERE `ap`.`achievId` = `a`.`id`
						AND `a`.`count` = `ap`.`progress`
						AND `ap`.`playerId` = `p`.`id`) AS `achiev_total`
					FROM `cs_players` AS `p`, `ac_achievs_players` AS `pa`, `ac_achievs` AS `a`
					WHERE `a`.`count` = `pa`.`progress`
						AND `p`.`id` = `pa`.`playerId`
						AND `pa`.`achievId` = `a`.`id`
						AND `a`.`id` = {$id}";
        return $sql;
    }

    public function get_achiev_players($id, $pag)
    {
        $sql = $this->sql_achiev_players($id);
        $query = $this->db->query($sql." LIMIT {$pag['offset']}, {$pag['per_page']}");
        return $query->result_array();
    }

    public function count_achiev_players($id)
    {
        $sql = $this->sql_achiev_players($id);
        return $this->db_count_all($sql);
    }
}
