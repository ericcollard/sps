<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250920141127 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accomodation (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, `current_date` DATE NOT NULL, location VARCHAR(255) NOT NULL, price DOUBLE PRECISION DEFAULT NULL, INDEX IDX_520D81B371F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE accomodation_racer (id INT AUTO_INCREMENT NOT NULL, accomodation_id INT NOT NULL, racer_id INT NOT NULL, racer_place TINYINT(1) NOT NULL, nonracer_place_count INT NOT NULL, INDEX IDX_2D081839FD70509C (accomodation_id), INDEX IDX_2D0818392112FF29 (racer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transport (id INT AUTO_INCREMENT NOT NULL, direction VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transport_racer (id INT AUTO_INCREMENT NOT NULL, transport_id INT NOT NULL, racer_id INT NOT NULL, racer_place TINYINT(1) NOT NULL, nonrace_place_count INT NOT NULL, available_place_count INT NOT NULL, INDEX IDX_B7B589A79909C13F (transport_id), INDEX IDX_B7B589A72112FF29 (racer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE accomodation ADD CONSTRAINT FK_520D81B371F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE accomodation_racer ADD CONSTRAINT FK_2D081839FD70509C FOREIGN KEY (accomodation_id) REFERENCES accomodation (id)');
        $this->addSql('ALTER TABLE accomodation_racer ADD CONSTRAINT FK_2D0818392112FF29 FOREIGN KEY (racer_id) REFERENCES racer (id)');
        $this->addSql('ALTER TABLE transport_racer ADD CONSTRAINT FK_B7B589A79909C13F FOREIGN KEY (transport_id) REFERENCES transport (id)');
        $this->addSql('ALTER TABLE transport_racer ADD CONSTRAINT FK_B7B589A72112FF29 FOREIGN KEY (racer_id) REFERENCES racer (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accomodation DROP FOREIGN KEY FK_520D81B371F7E88B');
        $this->addSql('ALTER TABLE accomodation_racer DROP FOREIGN KEY FK_2D081839FD70509C');
        $this->addSql('ALTER TABLE accomodation_racer DROP FOREIGN KEY FK_2D0818392112FF29');
        $this->addSql('ALTER TABLE transport_racer DROP FOREIGN KEY FK_B7B589A79909C13F');
        $this->addSql('ALTER TABLE transport_racer DROP FOREIGN KEY FK_B7B589A72112FF29');
        $this->addSql('DROP TABLE accomodation');
        $this->addSql('DROP TABLE accomodation_racer');
        $this->addSql('DROP TABLE transport');
        $this->addSql('DROP TABLE transport_racer');
    }
}
