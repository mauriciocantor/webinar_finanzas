<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230915184423 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE alphabet_soup (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, video_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, words CLOB NOT NULL --(DC2Type:json)
        , traps CLOB DEFAULT NULL --(DC2Type:json)
        , rows INTEGER NOT NULL, column_soup INTEGER NOT NULL, "current_date" DATETIME NOT NULL, CONSTRAINT FK_DFBF4BE929C1004E FOREIGN KEY (video_id) REFERENCES video (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_DFBF4BE929C1004E ON alphabet_soup (video_id)');
        $this->addSql('DROP TABLE _question_old_20230913');
        $this->addSql('CREATE TEMPORARY TABLE __temp__question AS SELECT id, video_id, question, type FROM question');
        $this->addSql('DROP TABLE question');
        $this->addSql('CREATE TABLE question (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, video_id INTEGER NOT NULL, question CLOB NOT NULL, type INTEGER NOT NULL, CONSTRAINT FK_B6F7494E29C1004E FOREIGN KEY (video_id) REFERENCES video (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO question (id, video_id, question, type) SELECT id, video_id, question, type FROM __temp__question');
        $this->addSql('DROP TABLE __temp__question');
        $this->addSql('CREATE INDEX IDX_B6F7494E29C1004E ON question (video_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE _question_old_20230913 (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, video_id INTEGER NOT NULL, question CLOB NOT NULL COLLATE "BINARY", type BLOB DEFAULT NULL, CONSTRAINT FK_B6F7494E29C1004E FOREIGN KEY (video_id) REFERENCES video (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_A97A301329C1004E ON _question_old_20230913 (video_id)');
        $this->addSql('DROP TABLE alphabet_soup');
        $this->addSql('CREATE TEMPORARY TABLE __temp__question AS SELECT id, video_id, question, type FROM question');
        $this->addSql('DROP TABLE question');
        $this->addSql('CREATE TABLE question (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, video_id INTEGER NOT NULL, question CLOB NOT NULL, type INTEGER DEFAULT NULL, CONSTRAINT FK_B6F7494E29C1004E FOREIGN KEY (video_id) REFERENCES video (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO question (id, video_id, question, type) SELECT id, video_id, question, type FROM __temp__question');
        $this->addSql('DROP TABLE __temp__question');
        $this->addSql('CREATE INDEX IDX_B6F7494E29C1004E ON question (video_id)');
    }
}
