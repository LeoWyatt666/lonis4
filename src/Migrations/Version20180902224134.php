<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180902224134 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cs_players CHANGE password password VARCHAR(50) DEFAULT NULL, CHANGE flags flags INT DEFAULT NULL, CHANGE email email VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE cs_players_vars DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE cs_players_vars ADD PRIMARY KEY (`key`, playerId)');
        $this->addSql('ALTER TABLE cs_servers CHANGE vip vip TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE kz_comm CHANGE name name VARCHAR(8) NOT NULL');
        $this->addSql('ALTER TABLE kz_diff CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE kz_ljs_type CHANGE name name VARCHAR(8) NOT NULL, CHANGE sort sort INT UNSIGNED NOT NULL, CHANGE fullname fullname VARCHAR(32) NOT NULL');
        $this->addSql('ALTER TABLE kz_map CHANGE mapname mapname VARCHAR(64) NOT NULL, CHANGE diff diff INT UNSIGNED DEFAULT NULL, CHANGE locked locked INT NOT NULL');
        $this->addSql('ALTER TABLE kz_map_update CHANGE mapname mapname VARCHAR(64) NOT NULL, CHANGE diff diff INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE kz_save CHANGE cp cp INT UNSIGNED NOT NULL, CHANGE go_cp go_cp INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE kz_weapons CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE best best TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cs_players CHANGE password password VARCHAR(50) DEFAULT \'\' COLLATE utf8_general_ci, CHANGE flags flags INT DEFAULT 0, CHANGE email email VARCHAR(100) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci');
        $this->addSql('ALTER TABLE cs_players_vars DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE cs_players_vars ADD PRIMARY KEY (playerId, `key`)');
        $this->addSql('ALTER TABLE cs_servers CHANGE vip vip TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE kz_comm CHANGE name name VARCHAR(8) NOT NULL COLLATE utf8_general_ci');
        $this->addSql('ALTER TABLE kz_diff CHANGE id id INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE kz_ljs_type CHANGE name name VARCHAR(8) NOT NULL COLLATE utf8_general_ci, CHANGE sort sort INT UNSIGNED DEFAULT 0 NOT NULL, CHANGE fullname fullname VARCHAR(32) DEFAULT \'0\' NOT NULL COLLATE utf8_general_ci');
        $this->addSql('ALTER TABLE kz_map CHANGE mapname mapname VARCHAR(64) NOT NULL COLLATE utf8_general_ci, CHANGE diff diff INT UNSIGNED DEFAULT 0, CHANGE locked locked INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE kz_map_update CHANGE mapname mapname VARCHAR(64) NOT NULL COLLATE utf8_general_ci, CHANGE diff diff INT UNSIGNED DEFAULT 0');
        $this->addSql('ALTER TABLE kz_save CHANGE cp cp INT UNSIGNED DEFAULT 0 NOT NULL, CHANGE go_cp go_cp INT UNSIGNED DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE kz_weapons CHANGE id id INT UNSIGNED NOT NULL, CHANGE best best TINYINT(1) DEFAULT \'0\' NOT NULL');
    }
}
