<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230918160400 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE alphabet_soup_result ADD COLUMN date_result DATETIME DEFAULT NULL');
        $this->addSql('CREATE TEMPORARY TABLE __temp__video AS SELECT id, hangman_id, thumbnail, link, availables_roles, with_test, description, video_id, role_test FROM video');
        $this->addSql('DROP TABLE video');
        $this->addSql('CREATE TABLE video (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, hangman_id INTEGER DEFAULT NULL, thumbnail VARCHAR(255) NOT NULL, link CLOB NOT NULL, availables_roles CLOB NOT NULL --(DC2Type:json)
        , with_test BLOB NOT NULL, description CLOB DEFAULT NULL, video_id VARCHAR(255) NOT NULL, role_test CLOB DEFAULT NULL --(DC2Type:json)
        , CONSTRAINT FK_7CC7DA2CB313A79C FOREIGN KEY (hangman_id) REFERENCES hangman (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO video (id, hangman_id, thumbnail, link, availables_roles, with_test, description, video_id, role_test) SELECT id, hangman_id, thumbnail, link, availables_roles, with_test, description, video_id, role_test FROM __temp__video');
        $this->addSql('DROP TABLE __temp__video');
        $this->addSql('CREATE INDEX IDX_7CC7DA2CB313A79C ON video (hangman_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__alphabet_soup_result AS SELECT id, alphabet_soup_id, user_id, live, found_word, is_correct FROM alphabet_soup_result');
        $this->addSql('DROP TABLE alphabet_soup_result');
        $this->addSql('CREATE TABLE alphabet_soup_result (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, alphabet_soup_id INTEGER NOT NULL, user_id INTEGER NOT NULL, live INTEGER NOT NULL, found_word CLOB NOT NULL --(DC2Type:json)
        , is_correct BOOLEAN NOT NULL, CONSTRAINT FK_F55E09F188211613 FOREIGN KEY (alphabet_soup_id) REFERENCES alphabet_soup (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F55E09F1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO alphabet_soup_result (id, alphabet_soup_id, user_id, live, found_word, is_correct) SELECT id, alphabet_soup_id, user_id, live, found_word, is_correct FROM __temp__alphabet_soup_result');
        $this->addSql('DROP TABLE __temp__alphabet_soup_result');
        $this->addSql('CREATE INDEX IDX_F55E09F188211613 ON alphabet_soup_result (alphabet_soup_id)');
        $this->addSql('CREATE INDEX IDX_F55E09F1A76ED395 ON alphabet_soup_result (user_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__video AS SELECT id, hangman_id, thumbnail, link, availables_roles, with_test, description, video_id, role_test FROM video');
        $this->addSql('DROP TABLE video');
        $this->addSql('CREATE TABLE video (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, hangman_id INTEGER DEFAULT NULL, thumbnail VARCHAR(255) NOT NULL, link CLOB NOT NULL, availables_roles CLOB NOT NULL --(DC2Type:json)
        , with_test BLOB NOT NULL, description CLOB DEFAULT NULL, video_id VARCHAR(255) NOT NULL, role_test CLOB DEFAULT NULL, CONSTRAINT FK_7CC7DA2CB313A79C FOREIGN KEY (hangman_id) REFERENCES hangman (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO video (id, hangman_id, thumbnail, link, availables_roles, with_test, description, video_id, role_test) SELECT id, hangman_id, thumbnail, link, availables_roles, with_test, description, video_id, role_test FROM __temp__video');
        $this->addSql('DROP TABLE __temp__video');
        $this->addSql('CREATE INDEX IDX_7CC7DA2CB313A79C ON video (hangman_id)');
    }
}
