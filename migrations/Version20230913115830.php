<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230913115830 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE video ADD COLUMN video_id VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__video AS SELECT id, thumbnail, link, availables_roles, with_test, description FROM video');
        $this->addSql('DROP TABLE video');
        $this->addSql('CREATE TABLE video (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, thumbnail VARCHAR(255) NOT NULL, link CLOB NOT NULL, availables_roles CLOB NOT NULL --(DC2Type:json)
        , with_test BLOB NOT NULL, description CLOB DEFAULT NULL)');
        $this->addSql('INSERT INTO video (id, thumbnail, link, availables_roles, with_test, description) SELECT id, thumbnail, link, availables_roles, with_test, description FROM __temp__video');
        $this->addSql('DROP TABLE __temp__video');
    }
}
