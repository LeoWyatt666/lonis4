<?
namespace App\Model;

use Doctrine\DBAL\Driver\Connection;

class RecordsModel
{
    private $conn;

    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }

    // Longjumps
    public function getLongjumpsPage()
    {
        return $this->conn->executeQuery(
                'SELECT `c`.`name`, `c`.`fullname` FROM `kz_ljs_recs` `r`
                LEFT JOIN `kz_comm` `c` ON `comm`=`c`.`name`
                GROUP BY `c`.`name` ORDER BY `c`.`sort`'
            )
            ->fetchAll();
    }

    public function getLongjumps($comm = 'xj')
    {
        return $this->conn->executeQuery(
                'SELECT `r`.*, `t`.`fullname` `type_name`, `c`.`fullname` `comm_name` FROM `kz_ljs_recs` `r`
				LEFT JOIN `kz_ljs_type` `t` ON `type`=`t`.`name`
				LEFT JOIN `kz_comm` `c` ON `comm`=`c`.`name`
				WHERE `c`.`name` = ? ORDER BY `c`.`sort`, `t`.`sort`, `block` DESC, `distance` DESC',
                [$comm]
            )
            ->fetchAll();
    }

    // Compare
    public function getCompare($comm)
    {
        return $this->conn->executeQuery(
                "SELECT `r1`.`map` `map`, `r1`.`mappath`,
                `r1`.`time` `wr_time`, `r1`.`player` `wr_player`, `r1`.`country` `wr_country`,
                `r2`.`time` `comm_time`, `r2`.`player` `comm_player`, `r2`.`country` `comm_country`,
                `t`.`time` `top_time`, `t`.`username` `top_player`
                FROM `kz_records` `r1`
                    LEFT JOIN (SELECT * FROM `kz_records` WHERE comm = ?) `r2` ON r1.map=r2.map AND r1.mappath=r2.mappath
                    LEFT JOIN `kz_view_map_top1` `t` ON r1.map=t.map AND `go_cp` = 0
                WHERE (r1.comm='xj' OR r1.comm='cc' OR r1.comm IS NULL) ORDER BY `r1`.`map`",
                [$comm]
            )
            ->fetchAll();
    }

    // Maps
    public function getMaps($comm)
    {
        return $this->conn->executeQuery(
                "SELECT `m`.`mapname`, `m`.`type`, `m`.`authors`, `m`.`date_old`,
                    `c`.`download`, `d`.`dname`, `d`.`dcolor`, `d`.`icon`
                FROM `kz_map` `m`
                    LEFT JOIN `kz_view_records` `r` ON `r`.`map` = `m`.`mapname`
                    LEFT JOIN `kz_comm` `c` ON `c`.`name`=`r`.`comm`
                    LEFT JOIN `kz_diff` `d` ON `d`.`id`=`m`.`diff`
                WHERE `r`.`comm` = ?
                ORDER BY `m`.`mapname`",
                [$comm]
            )
            ->fetchAll();
    }

    // Demos
    public function getDemos($comm)
    {
        return $this->conn->executeQuery(
                "SELECT `id`, `map`, `mappath`, `time`, `player`, `country`
				FROM kz_records WHERE `comm` = ?",
                [$comm]
            )
            ->fetchAll();
    }

    // Players
    public function getPlayers($comm)
    {
        return $this->conn->executeQuery(
                "SELECT `player`, COUNT(*) `count` FROM kz_records `r`
				WHERE `comm` = ? AND `time` IS NOT NULL
				GROUP BY `player` ORDER BY `count` DESC",
                [$comm]
            )
            ->fetchAll();
    }    

    // Player
    public function getPlayer($player)
    {
        return $this->conn->executeQuery(
                "SELECT * FROM kz_records WHERE `player` = ? LIMIT 1",
                [$player]
            )
            ->fetch();
    } 
    
    public function getPlayerComm($name)
    {
        return $this->conn->executeQuery(
                "SELECT `name`, `fullname` FROM `kz_comm` `c`
                JOIN (SELECT `comm` FROM `kz_records`
                        WHERE `player`= ? GROUP BY `comm`) `cc`
                ON `c`.`name`=`cc`.`comm`
                ORDER BY `sort`",
                [$name]
            )
            ->fetchAll();
    } 

    // Player demos
    public function getPlayerDemos($name, $comm)
    {
        return $this->conn->executeQuery(
                "SELECT * FROM kz_records WHERE `player`=? AND `comm`=?",
                [$name, $comm]
            )
            ->fetchAll();
    } 

    // Community
    public function getComms($comm = "")
    {
        if ($comm) {
            return $this->conn->executeQuery(
                    "SELECT `name`, `fullname` FROM kz_comm WHERE `name` = ? ORDER BY `sort` LIMIT 1",
                    [$comm]
                )
                ->fetch();
        }
        else {
            return $this->conn->executeQuery(
                    "SELECT `name`, `fullname` FROM kz_comm ORDER BY `sort`"
            )
            ->fetchAll();
        }
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

}