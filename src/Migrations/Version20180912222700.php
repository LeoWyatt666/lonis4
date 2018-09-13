<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180912222700 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE steam_users (id INT AUTO_INCREMENT NOT NULL, steam_id BIGINT NOT NULL, community_visibility_state INT NOT NULL, profile_state INT NOT NULL, profile_name VARCHAR(255) NOT NULL, last_log_off DATETIME NOT NULL, comment_permission INT NOT NULL, profile_url VARCHAR(255) NOT NULL, avatar VARCHAR(255) NOT NULL, persona_state INT NOT NULL, primary_clan_id BIGINT DEFAULT NULL, join_date DATETIME DEFAULT NULL, country_code VARCHAR(255) DEFAULT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json_array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cs_players CHANGE role role VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE kz_comm CHANGE name name VARCHAR(8) NOT NULL');
        $this->addSql('ALTER TABLE kz_ljs_type CHANGE name name VARCHAR(8) NOT NULL');
        $this->addSql('ALTER TABLE kz_map CHANGE mapname mapname VARCHAR(64) NOT NULL');
        $this->addSql('ALTER TABLE kz_map_update CHANGE mapname mapname VARCHAR(64) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE steam_users');
        $this->addSql('ALTER TABLE cs_players CHANGE role role VARCHAR(50) DEFAULT NULL COLLATE utf8_general_ci');
        $this->addSql('ALTER TABLE kz_comm CHANGE name name VARCHAR(8) NOT NULL COLLATE utf8_general_ci');
        $this->addSql('ALTER TABLE kz_ljs_type CHANGE name name VARCHAR(8) NOT NULL COLLATE utf8_general_ci');
        $this->addSql('ALTER TABLE kz_map CHANGE mapname mapname VARCHAR(64) NOT NULL COLLATE utf8_general_ci');
        $this->addSql('ALTER TABLE kz_map_update CHANGE mapname mapname VARCHAR(64) NOT NULL COLLATE utf8_general_ci');
    }
}
