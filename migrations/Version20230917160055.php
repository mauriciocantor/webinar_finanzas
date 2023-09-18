<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230917160055 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hangman_result (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, video_id INTEGER NOT NULL, user_id INTEGER NOT NULL, is_correct BOOLEAN NOT NULL, text CLOB NOT NULL, result_date DATETIME NOT NULL, CONSTRAINT FK_D88386EE29C1004E FOREIGN KEY (video_id) REFERENCES video (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D88386EEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_D88386EE29C1004E ON hangman_result (video_id)');
        $this->addSql('CREATE INDEX IDX_D88386EEA76ED395 ON hangman_result (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE hangman_result');
    }
}
