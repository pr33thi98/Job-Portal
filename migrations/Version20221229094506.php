<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221229094506 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE email email VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE jobs CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE log CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE description description VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE phone phone VARCHAR(15) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` CHANGE id id INT UNSIGNED NOT NULL, CHANGE phone phone VARCHAR(15) DEFAULT NULL');
        $this->addSql('ALTER TABLE application CHANGE id id INT UNSIGNED NOT NULL, CHANGE email email VARCHAR(254) NOT NULL');
        $this->addSql('CREATE INDEX user_id ON application (user_id)');
        $this->addSql('CREATE INDEX job_id ON application (job_id)');
        $this->addSql('ALTER TABLE log CHANGE id id INT UNSIGNED NOT NULL, CHANGE description description TEXT NOT NULL');
        $this->addSql('CREATE INDEX user_id ON log (user_id)');
        $this->addSql('CREATE INDEX job_id ON log (job_id)');
        $this->addSql('ALTER TABLE jobs CHANGE id id INT UNSIGNED NOT NULL');
    }
}
