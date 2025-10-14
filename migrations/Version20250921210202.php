<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250921210202 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE racer CHANGE license_number license_number VARCHAR(255) DEFAULT NULL, CHANGE is_ski_instructor_location is_ski_instructor_location VARCHAR(255) DEFAULT NULL, CHANGE size size INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE racer CHANGE license_number license_number VARCHAR(255) NOT NULL, CHANGE is_ski_instructor_location is_ski_instructor_location VARCHAR(255) NOT NULL, CHANGE size size INT NOT NULL');
    }
}
