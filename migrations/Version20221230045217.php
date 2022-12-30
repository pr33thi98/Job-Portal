<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221230045217 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` CHANGE id id INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE application CHANGE id id INT UNSIGNED NOT NULL, CHANGE user_id user_id INT UNSIGNED DEFAULT NULL, CHANGE job_id job_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT application_ibfk_1 FOREIGN KEY (job_id) REFERENCES jobs (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT application_ibfk_2 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX job_id ON application (job_id)');
        $this->addSql('CREATE INDEX user_id ON application (user_id)');
        $this->addSql('ALTER TABLE log CHANGE id id INT UNSIGNED NOT NULL, CHANGE user_id user_id INT UNSIGNED DEFAULT NULL, CHANGE job_id job_id INT UNSIGNED DEFAULT NULL, CHANGE description description TEXT NOT NULL');
        $this->addSql('ALTER TABLE log ADD CONSTRAINT log_ibfk_1 FOREIGN KEY (job_id) REFERENCES jobs (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE log ADD CONSTRAINT log_ibfk_2 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX job_id ON log (job_id)');
        $this->addSql('CREATE INDEX user_id ON log (user_id)');
        $this->addSql('ALTER TABLE jobs CHANGE id id INT UNSIGNED NOT NULL');
    }
}
