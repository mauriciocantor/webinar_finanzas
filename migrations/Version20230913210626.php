<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230913210626 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE video_user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, video_id INTEGER NOT NULL, "current_time" DOUBLE PRECISION NOT NULL, total_time DOUBLE PRECISION NOT NULL, CONSTRAINT FK_8A048B95A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8A048B9529C1004E FOREIGN KEY (video_id) REFERENCES video (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_8A048B95A76ED395 ON video_user (user_id)');
        $this->addSql('CREATE INDEX IDX_8A048B9529C1004E ON video_user (video_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__video AS SELECT id, thumbnail, link, availables_roles, with_test, description, video_id FROM video');
        $this->addSql('DROP TABLE video');
        $this->addSql('CREATE TABLE video (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, thumbnail VARCHAR(255) NOT NULL, link CLOB NOT NULL, availables_roles CLOB NOT NULL --(DC2Type:json)
        , with_test BLOB NOT NULL, description CLOB DEFAULT NULL, video_id VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO video (id, thumbnail, link, availables_roles, with_test, description, video_id) SELECT id, thumbnail, link, availables_roles, with_test, description, video_id FROM __temp__video');
        $this->addSql('DROP TABLE __temp__video');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE video_user');
        $this->addSql('CREATE TEMPORARY TABLE __temp__video AS SELECT id, thumbnail, link, availables_roles, with_test, description, video_id FROM video');
        $this->addSql('DROP TABLE video');
        $this->addSql('CREATE TABLE video (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, thumbnail VARCHAR(255) NOT NULL, link CLOB NOT NULL, availables_roles CLOB NOT NULL --(DC2Type:json)
        , with_test BLOB NOT NULL, description CLOB DEFAULT NULL, video_id VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO video (id, thumbnail, link, availables_roles, with_test, description, video_id) SELECT id, thumbnail, link, availables_roles, with_test, description, video_id FROM __temp__video');
        $this->addSql('DROP TABLE __temp__video');
    }
}
