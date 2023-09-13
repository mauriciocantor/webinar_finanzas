<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230913025732 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE _video_old_20230912');
        $this->addSql('CREATE TEMPORARY TABLE __temp__video AS SELECT id, thumbnail, link, availables_roles, with_test FROM video');
        $this->addSql('DROP TABLE video');
        $this->addSql('CREATE TABLE video (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, thumbnail VARCHAR(255) NOT NULL, link CLOB NOT NULL, availables_roles CLOB NOT NULL --(DC2Type:json)
        , with_test BLOB NOT NULL, description CLOB DEFAULT NULL)');
        $this->addSql('INSERT INTO video (id, thumbnail, link, availables_roles, with_test) SELECT id, thumbnail, link, availables_roles, with_test FROM __temp__video');
        $this->addSql('DROP TABLE __temp__video');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE _video_old_20230912 (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, thumbnail VARCHAR(255) NOT NULL COLLATE "BINARY", link CLOB NOT NULL COLLATE "BINARY", availables_roles CLOB NOT NULL COLLATE "BINARY" --(DC2Type:json)
        , with_test BLOB DEFAULT \'1\' NOT NULL)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__video AS SELECT id, thumbnail, link, availables_roles, with_test FROM video');
        $this->addSql('DROP TABLE video');
        $this->addSql('CREATE TABLE video (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, thumbnail VARCHAR(255) NOT NULL, link CLOB NOT NULL, availables_roles CLOB NOT NULL, with_test BLOB DEFAULT \'true\' NOT NULL)');
        $this->addSql('INSERT INTO video (id, thumbnail, link, availables_roles, with_test) SELECT id, thumbnail, link, availables_roles, with_test FROM __temp__video');
        $this->addSql('DROP TABLE __temp__video');
    }
}
