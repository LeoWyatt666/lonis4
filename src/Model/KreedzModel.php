<?
namespace App\Model;

use Doctrine\DBAL\Driver\Connection;

class KreedzModel
{
    private $conn;

    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }

    // Duels
    public function getDuels()
    {
        return $this->conn->executeQuery(
                'SELECT `d`.*, `pl1`.`username` `name1`, `pl2`.`username` `name2` FROM `kz_duel` `d`
				LEFT JOIN `cs_players` `pl1` ON `pl1`.`id` = `player1`
				LEFT JOIN `cs_players` `pl2` ON `pl2`.`id` = `player2`'
            )
            ->fetchAll();
    }

    // Maps
    public function getMaps($type, $map)
    {
        $where = $this->getTypes($type);
        $where .= $map ? "AND `map` LIKE :map ESCAPE '!'" : '';

        return $this->conn->executeQuery(
                "SELECT `t`.`map` `mapname`, `t`.* FROM `kz_view_map_top1` `t` WHERE 1 {$where} ORDER BY `map`",
                ['map' => "%{$map}%"]
            )
            ->fetchAll();
    }

    // Maps Norec
    public function getMapsNorec()
    {
        return $this->conn->executeQuery(
                'SELECT t.*, m.mapname, m.type mtype FROM `kz_map` `m` 
                LEFT JOIN `kz_view_map_top1` `t` ON `t`.`map` = `m`.`mapname`
            WHERE `t`.`id` IS NULL ORDER By `mapname`'
            )
            ->fetchAll();
    }

    // Check map
    public function getCountMapTop($map)
    {
        return $this->conn->executeQuery(
                'SELECT COUNT(DISTINCT `map`) FROM `kz_map_top` WHERE `map` = ?',
                [$map]
            )
            ->fetch();
    }

    // Map players
    public function getMapPlayers($map, $type)
    {
        $where = $this->getTypes($type);

        return $this->conn->executeQuery(
                "SELECT `t`.* FROM `kz_view_map_top` `t`
				JOIN (
					SELECT `map`, `player`, min(`time`) as `mtime` FROM `kz_view_map_top`
						WHERE `map` = ? GROUP BY `player` ) AS `tmp`
				ON `t`.`player` = `tmp`.`player` AND `t`.`time` = `tmp`.`mtime`
				WHERE 1 {$where} ORDER BY `time`",
                [$map]
            )
            ->fetchAll();
    }

    // Map Last
    public function getMapLast($type)
    {
        $where = $this->getTypes($type);

        return $this->conn->executeQuery(
                "SELECT * FROM `kz_view_map_top` WHERE 1 {$where} ORDER BY `time_add` DESC, `map` LIMIT 10000"
            )
            ->fetchAll();
    }

    // Map info
    public function getMapInfo($map)
    {
        return $this->conn->executeQuery(
                "SELECT *, `type` `mtype` FROM `kz_map`
                    LEFT JOIN `kz_comm` ON `comm`=`name`
                    LEFT JOIN `kz_diff` `d` ON `d`.`id`=`diff`
                WHERE `mapname` = ? ORDER BY `mapname` LIMIT 1",
                [$map]
            )
            ->fetch();
    }

    // Map Last
    public function getRecords($map)
    {
        return $this->conn->executeQuery(
                "SELECT * FROM `kz_records` `r`, `kz_comm` `c`
				WHERE `map` = ? AND `name` = `comm`
				ORDER BY `sort`, `mappath`",
                [$map]
            )
            ->fetchAll();
    }

    // Players
    public function getPlayers($type, $search)
    {
        $where = $this->getTypes($type);
        $where2 = $search ? " AND `username` LIKE :search ESCAPE '!'" : '';

        return $this->conn->executeQuery(
                "SELECT `p`.`id`, `p`.`username`, `t`.`all`, `t1`.`top` FROM `cs_players` `p`
				JOIN (
					SELECT COUNT(DISTINCT `map`) as `all`, `player` FROM kz_view_map_top
					WHERE 1 {$where} GROUP BY `player`) as `t` ON `id` = `t`.`player`
				LEFT JOIN (
					SELECT COUNT(DISTINCT `map`) as `top`, `player` FROM kz_view_map_top1
					WHERE 1 {$where} GROUP BY `player`) as `t1` ON `id` = `t1`.`player`
				WHERE 1 {$where2} AND `all`>50 ORDER BY `all` DESC, `username`",
                ['search' => "%{$search}%"]
            )
            ->fetchAll();
    }   

    // Player
    public function getPlayer($id)
    {
        return $this->conn->executeQuery(
                "SELECT `id`, `username`, `steam_id`, `steam_id_64`, `email` FROM `cs_players` WHERE `id` = ? LIMIT 1",
                [$id]
            )
            ->fetch();
    }

    // Player Maps
    public function getPlayerMaps($id, $type, $search)
    {
        $where = $this->getTypes($type);
        $where .= $search ? " AND `mts`.`map` LIKE :search ESCAPE '!'" : '';

        return $this->conn->executeQuery(
                "SELECT `mts`.* FROM `kz_view_map_top` `mts`
                    JOIN (SELECT `map`, min(`time`) `mtime` FROM `kz_view_map_top`
                            WHERE `player` = :id GROUP BY `map` ORDER BY `map`) `mt`
                        ON `mts`.`map`=`mt`.`map` AND `mts`.`time`=`mt`.`mtime`
                    WHERE 1 {$where} ORDER BY `map`",
                ['id'=>$id, 'search'=>"%{$search}%"]
            )
            ->fetchAll();
    }

    // Player Maps
    public function getPlayerTop1($id, $type)
    {
        $where = $this->getTypes($type);

        return $this->conn->executeQuery(
                "SELECT * FROM `kz_view_map_top1` WHERE `player` = ? {$where}",
                [$id]
            )
            ->fetchAll();
    }

    // Player Norec
    public function getPlayerNorec($id)
    {
        $where = $this->getTypes($type);

        return $this->conn->executeQuery(
                "SELECT `m`.`mapname`, `m`.`type`, `t1`.`player`, `t1`.`username`, `t1`.`time`,
                        `t1`.`cp`, `t1`.`go_cp`, `t1`.`weapon`, `t1`.`wname`,
                        `t1`.`dname`, `t1`.`dcolor`, `t1`.`icon`
                FROM `kz_map` `m`
                    LEFT JOIN `kz_view_map_top1` `t1` ON `t1`.`map` = `m`.`mapname`
                WHERE `mapname` NOT IN (
                    SELECT DISTINCT `map` FROM `kz_map_top` WHERE `player` = ?)",
                [$id]
            )
            ->fetchAll();
    }

    // Functions
    private function getTypes($type)
    {
        $types = array(
            'pro' => 'AND (`go_cp` = 0 AND `pspeed` = 250 )',
            'nub' => 'AND (`go_cp` != 0 OR NOT `pspeed` = 250)',
            'all' => ''
        );
        return isset($types[$type]) ? $types[$type] : '';
    }
    
}