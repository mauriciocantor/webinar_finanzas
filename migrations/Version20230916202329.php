<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230916202329 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__hangman AS SELECT id, dictionary, attempt FROM hangman');
        $this->addSql('DROP TABLE hangman');
        $this->addSql('CREATE TABLE hangman (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, dictionary CLOB NOT NULL --(DC2Type:json)
        , attempt INTEGER NOT NULL)');
        $this->addSql('INSERT INTO hangman (id, dictionary, attempt) SELECT id, dictionary, attempt FROM __temp__hangman');
        $this->addSql('DROP TABLE __temp__hangman');
        $this->addSql('CREATE TEMPORARY TABLE __temp__video AS SELECT id, thumbnail, link, availables_roles, with_test, description, video_id FROM video');
        $this->addSql('DROP TABLE video');
        $this->addSql('CREATE TABLE video (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, hangman_id INTEGER DEFAULT NULL, thumbnail VARCHAR(255) NOT NULL, link CLOB NOT NULL, availables_roles CLOB NOT NULL --(DC2Type:json)
        , with_test BLOB NOT NULL, description CLOB DEFAULT NULL, video_id VARCHAR(255) NOT NULL, CONSTRAINT FK_7CC7DA2CB313A79C FOREIGN KEY (hangman_id) REFERENCES hangman (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO video (id, thumbnail, link, availables_roles, with_test, description, video_id) SELECT id, thumbnail, link, availables_roles, with_test, description, video_id FROM __temp__video');
        $this->addSql('DROP TABLE __temp__video');
        $this->addSql('CREATE INDEX IDX_7CC7DA2CB313A79C ON video (hangman_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__hangman AS SELECT id, dictionary, attempt FROM hangman');
        $this->addSql('DROP TABLE hangman');
        $this->addSql('CREATE TABLE hangman (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, video_id INTEGER NOT NULL, dictionary CLOB NOT NULL --(DC2Type:json)
        , attempt INTEGER NOT NULL, CONSTRAINT FK_F08D495F29C1004E FOREIGN KEY (video_id) REFERENCES video (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO hangman (id, dictionary, attempt) SELECT id, dictionary, attempt FROM __temp__hangman');
        $this->addSql('DROP TABLE __temp__hangman');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F08D495F29C1004E ON hangman (video_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__video AS SELECT id, thumbnail, link, availables_roles, with_test, description, video_id FROM video');
        $this->addSql('DROP TABLE video');
        $this->addSql('CREATE TABLE video (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, thumbnail VARCHAR(255) NOT NULL, link CLOB NOT NULL, availables_roles CLOB NOT NULL --(DC2Type:json)
        , with_test BLOB NOT NULL, description CLOB DEFAULT NULL, video_id VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO video (id, thumbnail, link, availables_roles, with_test, description, video_id) SELECT id, thumbnail, link, availables_roles, with_test, description, video_id FROM __temp__video');
        $this->addSql('DROP TABLE __temp__video');
    }
}
