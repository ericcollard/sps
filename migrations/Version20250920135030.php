<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250920135030 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, startdate DATE NOT NULL, enddate DATE NOT NULL, title VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, memo VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_racer (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, racer_id INT NOT NULL, validated TINYINT(1) NOT NULL, finance_correction DOUBLE PRECISION DEFAULT NULL, finance_correction_reason VARCHAR(255) DEFAULT NULL, INDEX IDX_6BA19F7371F7E88B (event_id), INDEX IDX_6BA19F732112FF29 (racer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skiday (id INT AUTO_INCREMENT NOT NULL, `current_date` DATE NOT NULL, location VARCHAR(255) NOT NULL, day_type VARCHAR(255) NOT NULL, memo VARCHAR(255) DEFAULT NULL, price_youth DOUBLE PRECISION DEFAULT NULL, price_youth_limit INT DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, lunch_price DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event_racer ADD CONSTRAINT FK_6BA19F7371F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE event_racer ADD CONSTRAINT FK_6BA19F732112FF29 FOREIGN KEY (racer_id) REFERENCES racer (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event_racer DROP FOREIGN KEY FK_6BA19F7371F7E88B');
        $this->addSql('ALTER TABLE event_racer DROP FOREIGN KEY FK_6BA19F732112FF29');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_racer');
        $this->addSql('DROP TABLE skiday');
    }
}
