<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230918012745 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__alphabet_soup_result AS SELECT id, many_to_one_id, user_id, live, found_word, is_correct FROM alphabet_soup_result');
        $this->addSql('DROP TABLE alphabet_soup_result');
        $this->addSql('CREATE TABLE alphabet_soup_result (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, alphabet_soup_id INTEGER NOT NULL, user_id INTEGER NOT NULL, live INTEGER NOT NULL, found_word CLOB NOT NULL --(DC2Type:json)
        , is_correct BOOLEAN NOT NULL, CONSTRAINT FK_F55E09F1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F55E09F188211613 FOREIGN KEY (alphabet_soup_id) REFERENCES alphabet_soup (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO alphabet_soup_result (id, alphabet_soup_id, user_id, live, found_word, is_correct) SELECT id, many_to_one_id, user_id, live, found_word, is_correct FROM __temp__alphabet_soup_result');
        $this->addSql('DROP TABLE __temp__alphabet_soup_result');
        $this->addSql('CREATE INDEX IDX_F55E09F1A76ED395 ON alphabet_soup_result (user_id)');
        $this->addSql('CREATE INDEX IDX_F55E09F188211613 ON alphabet_soup_result (alphabet_soup_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__alphabet_soup_result AS SELECT id, alphabet_soup_id, user_id, live, found_word, is_correct FROM alphabet_soup_result');
        $this->addSql('DROP TABLE alphabet_soup_result');
        $this->addSql('CREATE TABLE alphabet_soup_result (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, many_to_one_id INTEGER NOT NULL, user_id INTEGER NOT NULL, live INTEGER NOT NULL, found_word CLOB NOT NULL --(DC2Type:json)
        , is_correct BOOLEAN NOT NULL, CONSTRAINT FK_F55E09F1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F55E09F1EAB5DEB FOREIGN KEY (many_to_one_id) REFERENCES alphabet_soup (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO alphabet_soup_result (id, many_to_one_id, user_id, live, found_word, is_correct) SELECT id, alphabet_soup_id, user_id, live, found_word, is_correct FROM __temp__alphabet_soup_result');
        $this->addSql('DROP TABLE __temp__alphabet_soup_result');
        $this->addSql('CREATE INDEX IDX_F55E09F1A76ED395 ON alphabet_soup_result (user_id)');
        $this->addSql('CREATE INDEX IDX_F55E09F1EAB5DEB ON alphabet_soup_result (many_to_one_id)');
    }
}
