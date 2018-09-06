<?
namespace App\Model;

use Doctrine\DBAL\Driver\Connection;

class AchievsModel
{
    private $conn;

    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }

    public function getAchievs($locale)
    {
        return $this->conn->executeQuery(
                'SELECT `icon`, `id` AS `aId`, `name`, `desc`,
				(SELECT COUNT(*) FROM `ac_achievs` `a`, `ac_achievs_players` `ap`
				JOIN (SELECT @playerCount := (SELECT COUNT(*) FROM `cs_players`)) `player_count`
				WHERE `ap`.`achievId` = `a`.`id`
					AND `a`.`count` = `ap`.`progress`
					AND `ap`.`achievId` = `aId`)/@playerCount*100 AS `completed`
				FROM `ac_view_achievs_list` WHERE `lang`= ? ORDER BY `completed` DESC',
                [$locale]
            )
            ->fetchAll();
    }

    public function getAchievPlayers($id)
    {
        return $this->conn->executeQuery(
                'SELECT p.steam_id_64, p.email, `p`.`id`, `p`.`username` AS `plname`,
				(SELECT COUNT(*) FROM `ac_achievs_players` `ap`, `ac_achievs` `a`
					WHERE `ap`.`achievId` = `a`.`id`
						AND `a`.`count` = `ap`.`progress`
						AND `ap`.`playerId` = `p`.`id`) AS `achiev_total`
					FROM `cs_players` AS `p`, `ac_achievs_players` AS `pa`, `ac_achievs` AS `a`
					WHERE `a`.`count` = `pa`.`progress`
						AND `p`.`id` = `pa`.`playerId`
						AND `pa`.`achievId` = `a`.`id`
						AND `a`.`id` = ?',
                [$id]
            )
            ->fetchAll();
    }

    public function getAchiev($locale, $id)
    {
        return $this->conn->executeQuery(
                'SELECT `id`, `name`, `desc` FROM `ac_view_achievs_list` 
                 WHERE `lang`= ? AND `id` = ? 
                 LIMIT 1',
                [$locale, $id]
            )
            ->fetch();
    }

    public function getPlayerAchievs($id)
    {
        return $this->conn->executeQuery(
                'SELECT COUNT(*) as `achievCompleted` FROM `ac_achievs_players`, `ac_achievs`
                WHERE `achievId` = `id` AND `count` = `progress` AND `playerId` = {$id} 
                LIMIT 1',
                [$locale, $id]
            )
            ->fetch();
    }

    public function getAchievsPlayer($id)
    {
        return $this->conn->executeQuery(
                'SELECT `icon`, `a`.`id`, `a`.`name`, `a`.`desc`, `count`,
                    IF(`progress` IS NULL, 0, `progress`) AS `progress`,
                    `p`.`username` as `plname`
                FROM `ac_view_achievs_list` `a`
                LEFT JOIN `ac_achievs_players` `pa` ON `pa`.`achievId` = `a`.`id`
                LEFT JOIN `cs_players` `p` ON `pa`.`playerId` = `p`.`id`
                WHERE `a`.`lang`=? AND `p`.`id` = ?
                ORDER BY `progress` = `count` DESC, `progress`/`count` DESC',
                [$locale, $id]
            )
            ->fetchAll();
    }

    public function getAchievsPlayers()
    {
        return $this->conn->executeQuery(
                'SELECT steam_id_64, email, `id`, `username`,
                (SELECT COUNT(*) `achiev_total` FROM `ac_achievs_players` `pa`, `ac_achievs` `a`
                    WHERE `achievId` = `a`.`id` AND `count` = `progress` AND `playerId` = `p`.`id`) AS `achiev_total`
                FROM `cs_players` `p`
                HAVING `achiev_total` > 0 ORDER BY `achiev_total` DESC'
            )
            ->fetchAll();
    }
}