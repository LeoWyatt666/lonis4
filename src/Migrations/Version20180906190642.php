<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180906190642 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cs_players ADD role ENUM(\'ROLE_USER\', \'ROLE_ADMIN\'), CHANGE email email VARCHAR(254) NOT NULL');
        $this->addSql('ALTER TABLE cs_players RENAME INDEX name TO username');
        $this->addSql('ALTER TABLE kz_comm CHANGE name name VARCHAR(8) NOT NULL');
        $this->addSql('ALTER TABLE kz_diff CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE kz_ljs_type CHANGE name name VARCHAR(8) NOT NULL');
        $this->addSql('ALTER TABLE kz_map CHANGE mapname mapname VARCHAR(64) NOT NULL');
        $this->addSql('ALTER TABLE kz_map_update CHANGE mapname mapname VARCHAR(64) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cs_players DROP role, CHANGE email email VARCHAR(100) NOT NULL COLLATE utf8_general_ci');
        $this->addSql('ALTER TABLE cs_players RENAME INDEX username TO name');
        $this->addSql('ALTER TABLE kz_comm CHANGE name name VARCHAR(8) NOT NULL COLLATE utf8_general_ci');
        $this->addSql('ALTER TABLE kz_diff CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE kz_ljs_type CHANGE name name VARCHAR(8) NOT NULL COLLATE utf8_general_ci');
        $this->addSql('ALTER TABLE kz_map CHANGE mapname mapname VARCHAR(64) NOT NULL COLLATE utf8_general_ci');
        $this->addSql('ALTER TABLE kz_map_update CHANGE mapname mapname VARCHAR(64) NOT NULL COLLATE utf8_general_ci');
    }
}
