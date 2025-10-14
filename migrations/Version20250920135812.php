<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250920135812 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE skiday_racer (id INT AUTO_INCREMENT NOT NULL, racer_id INT NOT NULL, skiday_id INT NOT NULL, register_racer TINYINT(1) NOT NULL, training_racer TINYINT(1) NOT NULL, skipass_racer TINYINT(1) NOT NULL, skipass_nonracer_count INT NOT NULL, lunch_racer TINYINT(1) NOT NULL, INDEX IDX_3782DB82112FF29 (racer_id), INDEX IDX_3782DB8488BEE0 (skiday_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE skiday_racer ADD CONSTRAINT FK_3782DB82112FF29 FOREIGN KEY (racer_id) REFERENCES racer (id)');
        $this->addSql('ALTER TABLE skiday_racer ADD CONSTRAINT FK_3782DB8488BEE0 FOREIGN KEY (skiday_id) REFERENCES skiday (id)');
        $this->addSql('ALTER TABLE skiday ADD event_id INT NOT NULL');
        $this->addSql('ALTER TABLE skiday ADD CONSTRAINT FK_8E59D09B71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('CREATE INDEX IDX_8E59D09B71F7E88B ON skiday (event_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE skiday_racer DROP FOREIGN KEY FK_3782DB82112FF29');
        $this->addSql('ALTER TABLE skiday_racer DROP FOREIGN KEY FK_3782DB8488BEE0');
        $this->addSql('DROP TABLE skiday_racer');
        $this->addSql('ALTER TABLE skiday DROP FOREIGN KEY FK_8E59D09B71F7E88B');
        $this->addSql('DROP INDEX IDX_8E59D09B71F7E88B ON skiday');
        $this->addSql('ALTER TABLE skiday DROP event_id');
    }
}
