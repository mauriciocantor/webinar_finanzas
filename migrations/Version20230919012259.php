<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230919012259 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE alphabet_soup (id INT AUTO_INCREMENT NOT NULL, video_id INT NOT NULL, title VARCHAR(255) NOT NULL, words JSON NOT NULL, traps JSON DEFAULT NULL, rows INT NOT NULL, column_soup INT NOT NULL, `current_date` DATETIME NOT NULL, INDEX IDX_DFBF4BE929C1004E (video_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE alphabet_soup_result (id INT AUTO_INCREMENT NOT NULL, alphabet_soup_id INT NOT NULL, user_id INT NOT NULL, live INT NOT NULL, found_word JSON NOT NULL, is_correct TINYINT(1) NOT NULL, date_result DATETIME DEFAULT NULL, INDEX IDX_F55E09F188211613 (alphabet_soup_id), INDEX IDX_F55E09F1A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE answer (id INT AUTO_INCREMENT NOT NULL, question_id INT NOT NULL, text LONGTEXT NOT NULL, is_valid TINYINT(1) NOT NULL, INDEX IDX_DADD4A251E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hangman (id INT AUTO_INCREMENT NOT NULL, dictionary JSON NOT NULL, attempt INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hangman_result (id INT AUTO_INCREMENT NOT NULL, video_id INT NOT NULL, user_id INT NOT NULL, is_correct TINYINT(1) NOT NULL, text LONGTEXT NOT NULL, result_date DATETIME NOT NULL, INDEX IDX_D88386EE29C1004E (video_id), INDEX IDX_D88386EEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, video_id INT NOT NULL, question LONGTEXT NOT NULL, type INT NOT NULL, INDEX IDX_B6F7494E29C1004E (video_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_answer (id INT AUTO_INCREMENT NOT NULL, answer_id INT NOT NULL, user_id INT NOT NULL, date_created DATETIME NOT NULL, INDEX IDX_BF8F5118AA334807 (answer_id), INDEX IDX_BF8F5118A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video (id INT AUTO_INCREMENT NOT NULL, hangman_id INT DEFAULT NULL, thumbnail VARCHAR(255) NOT NULL, link LONGTEXT NOT NULL, availables_roles JSON NOT NULL, with_test VARBINARY(255) NOT NULL, description LONGTEXT DEFAULT NULL, video_id VARCHAR(255) NOT NULL, role_test JSON DEFAULT NULL, INDEX IDX_7CC7DA2CB313A79C (hangman_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video_user (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, video_id INT NOT NULL, `current_time` DOUBLE PRECISION NOT NULL, total_time DOUBLE PRECISION NOT NULL, INDEX IDX_8A048B95A76ED395 (user_id), INDEX IDX_8A048B9529C1004E (video_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE alphabet_soup ADD CONSTRAINT FK_DFBF4BE929C1004E FOREIGN KEY (video_id) REFERENCES video (id)');
        $this->addSql('ALTER TABLE alphabet_soup_result ADD CONSTRAINT FK_F55E09F188211613 FOREIGN KEY (alphabet_soup_id) REFERENCES alphabet_soup (id)');
        $this->addSql('ALTER TABLE alphabet_soup_result ADD CONSTRAINT FK_F55E09F1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A251E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE hangman_result ADD CONSTRAINT FK_D88386EE29C1004E FOREIGN KEY (video_id) REFERENCES video (id)');
        $this->addSql('ALTER TABLE hangman_result ADD CONSTRAINT FK_D88386EEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E29C1004E FOREIGN KEY (video_id) REFERENCES video (id)');
        $this->addSql('ALTER TABLE user_answer ADD CONSTRAINT FK_BF8F5118AA334807 FOREIGN KEY (answer_id) REFERENCES answer (id)');
        $this->addSql('ALTER TABLE user_answer ADD CONSTRAINT FK_BF8F5118A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2CB313A79C FOREIGN KEY (hangman_id) REFERENCES hangman (id)');
        $this->addSql('ALTER TABLE video_user ADD CONSTRAINT FK_8A048B95A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE video_user ADD CONSTRAINT FK_8A048B9529C1004E FOREIGN KEY (video_id) REFERENCES video (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE alphabet_soup DROP FOREIGN KEY FK_DFBF4BE929C1004E');
        $this->addSql('ALTER TABLE alphabet_soup_result DROP FOREIGN KEY FK_F55E09F188211613');
        $this->addSql('ALTER TABLE alphabet_soup_result DROP FOREIGN KEY FK_F55E09F1A76ED395');
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A251E27F6BF');
        $this->addSql('ALTER TABLE hangman_result DROP FOREIGN KEY FK_D88386EE29C1004E');
        $this->addSql('ALTER TABLE hangman_result DROP FOREIGN KEY FK_D88386EEA76ED395');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E29C1004E');
        $this->addSql('ALTER TABLE user_answer DROP FOREIGN KEY FK_BF8F5118AA334807');
        $this->addSql('ALTER TABLE user_answer DROP FOREIGN KEY FK_BF8F5118A76ED395');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2CB313A79C');
        $this->addSql('ALTER TABLE video_user DROP FOREIGN KEY FK_8A048B95A76ED395');
        $this->addSql('ALTER TABLE video_user DROP FOREIGN KEY FK_8A048B9529C1004E');
        $this->addSql('DROP TABLE alphabet_soup');
        $this->addSql('DROP TABLE alphabet_soup_result');
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE hangman');
        $this->addSql('DROP TABLE hangman_result');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_answer');
        $this->addSql('DROP TABLE video');
        $this->addSql('DROP TABLE video_user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
