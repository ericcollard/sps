<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250920133219 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accounting (id INT AUTO_INCREMENT NOT NULL, family_id INT NOT NULL, racer_id INT NOT NULL, reason VARCHAR(255) NOT NULL, value DOUBLE PRECISION NOT NULL, username VARCHAR(255) NOT NULL, INDEX IDX_6DC501E5C35E566A (family_id), INDEX IDX_6DC501E52112FF29 (racer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE racer (id INT AUTO_INCREMENT NOT NULL, family_id INT NOT NULL, name VARCHAR(255) NOT NULL, sex VARCHAR(255) NOT NULL, birth_date DATE DEFAULT NULL, license_number VARCHAR(255) NOT NULL, sntf TINYINT(1) NOT NULL, is_racer TINYINT(1) NOT NULL, is_ski_coach TINYINT(1) NOT NULL, is_ski_instructor_location VARCHAR(255) NOT NULL, license_activated TINYINT(1) NOT NULL, license_type VARCHAR(255) NOT NULL, club_activated TINYINT(1) NOT NULL, medical_activated TINYINT(1) NOT NULL, apply_activated TINYINT(1) NOT NULL, medical VARCHAR(255) NOT NULL, size INT NOT NULL, weight INT DEFAULT NULL, INDEX IDX_2ABA2E5FC35E566A (family_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE accounting ADD CONSTRAINT FK_6DC501E5C35E566A FOREIGN KEY (family_id) REFERENCES family (id)');
        $this->addSql('ALTER TABLE accounting ADD CONSTRAINT FK_6DC501E52112FF29 FOREIGN KEY (racer_id) REFERENCES racer (id)');
        $this->addSql('ALTER TABLE racer ADD CONSTRAINT FK_2ABA2E5FC35E566A FOREIGN KEY (family_id) REFERENCES family (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accounting DROP FOREIGN KEY FK_6DC501E5C35E566A');
        $this->addSql('ALTER TABLE accounting DROP FOREIGN KEY FK_6DC501E52112FF29');
        $this->addSql('ALTER TABLE racer DROP FOREIGN KEY FK_2ABA2E5FC35E566A');
        $this->addSql('DROP TABLE accounting');
        $this->addSql('DROP TABLE racer');
    }
}
