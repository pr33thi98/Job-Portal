<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221230041550 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE application (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, job_id INT NOT NULL, applied_at DATETIME NOT NULL, resume VARCHAR(30) DEFAULT NULL, email VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jobs (id INT AUTO_INCREMENT NOT NULL, job_title VARCHAR(40) NOT NULL, job_description VARCHAR(100) NOT NULL, skills VARCHAR(50) DEFAULT NULL, job_location VARCHAR(30) NOT NULL, experience INT NOT NULL, created_at DATETIME NOT NULL, modified_at DATETIME NOT NULL, expiry DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE log (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, log_time DATETIME NOT NULL, job_id INT DEFAULT NULL, description VARCHAR(100) NOT NULL, type SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(30) NOT NULL, first_name VARCHAR(20) NOT NULL, last_name VARCHAR(20) NOT NULL, dob DATE NOT NULL, city VARCHAR(30) NOT NULL, phone VARCHAR(15) NOT NULL, password VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        
    }
}
