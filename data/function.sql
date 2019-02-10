-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.7.20 - MySQL Community Server (GPL)
-- Операционная система:         Win64
-- HeidiSQL Версия:              9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры для процедура lonis.kz_map_top1_update
DELIMITER //
CREATE PROCEDURE `kz_map_top1_update`()
BEGIN
INSERT IGNORE kz_map_top1
SELECT `t`.`id` AS `id`,`t`.`map` AS `map`,`t`.`player` AS `player`,`t`.`time` AS `time`,`t`.`cp` AS `cp`,`t`.`go_cp` AS `go_cp`,`t`.`weapon` AS `weapon`,`t`.`time_add` AS `time_add`
FROM `kz_map_top` `t`
JOIN `kz_view_map_top_min` ON(((`t`.`map` = `kz_view_map_top_min`.`minmap`) AND (`t`.`time` = `kz_view_map_top_min`.`mintime`)));
END//
DELIMITER ;

-- Дамп структуры для триггер lonis.kz_map_top_after_insert
-- SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `kz_map_top_after_insert` AFTER INSERT ON `kz_map_top` FOR EACH ROW BEGIN
SET @pspeed = (SELECT `pspeed` FROM kz_weapons w WHERE w.id = NEW.weapon);
IF(NEW.go_cp = 0) THEN
	SET @id = (
		SELECT mt.id FROM kz_map_top mt
		JOIN kz_weapons w ON w.id=mt.weapon
		WHERE mt.go_cp=0 AND w.pspeed=@pspeed AND mt.map=NEW.map
		ORDER BY mt.`time` LIMIT 1);
ELSE
	SET @id = (
		SELECT mt.id FROM kz_map_top mt
		JOIN kz_weapons w ON w.id=mt.weapon 
		WHERE mt.go_cp>0 AND w.pspeed=@pspeed AND mt.map=NEW.map
		ORDER BY mt.`time` LIMIT 1);
END IF;

SET @mtime = (SELECT `time` FROM kz_map_top1 mt WHERE id=@id);

IF (@mtime IS NULL) THEN
	INSERT INTO kz_map_top1 SET
		`id` = NEW.id,
		`map` = NEW.map,
		`player` = NEW.player,
		`time` = NEW.`time`,
		`cp` = NEW.cp,
		`go_cp` = NEW.`go_cp`,
		`weapon` = NEW.weapon;
ELSEIF (NEW.`time` < @mtime) THEN
	UPDATE kz_map_top1 SET
		`id` = NEW.id,
		`map` = NEW.map,
		`player` = NEW.player,
		`time` = NEW.`time`,
		`cp` = NEW.cp,
		`go_cp` = NEW.`go_cp`,
		`weapon` = NEW.weapon
	WHERE id=@id;
END IF;
END//
DELIMITER ;
-- SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
