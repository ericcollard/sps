<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250921203333 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE family ADD adress1 VARCHAR(255) DEFAULT NULL, ADD adress2 VARCHAR(255) DEFAULT NULL, DROP address1, DROP address2');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE family ADD address1 VARCHAR(255) DEFAULT NULL, ADD address2 VARCHAR(255) DEFAULT NULL, DROP adress1, DROP adress2');
    }
}
