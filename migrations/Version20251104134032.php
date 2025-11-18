<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251104134032 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accomodation (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, day_date DATE NOT NULL, location VARCHAR(255) NOT NULL, price DOUBLE PRECISION DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, deleted_by VARCHAR(255) DEFAULT NULL, INDEX IDX_520D81B371F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE accomodation_racer (id INT AUTO_INCREMENT NOT NULL, accomodation_id INT NOT NULL, racer_id INT NOT NULL, racer_place TINYINT(1) NOT NULL, nonracer_place_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, deleted_by VARCHAR(255) DEFAULT NULL, INDEX IDX_2D081839FD70509C (accomodation_id), INDEX IDX_2D0818392112FF29 (racer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE accounting (id INT AUTO_INCREMENT NOT NULL, family_id INT DEFAULT NULL, racer_id INT DEFAULT NULL, event_id INT DEFAULT NULL, imputation_date DATETIME NOT NULL, reason VARCHAR(255) NOT NULL, value DOUBLE PRECISION NOT NULL, username VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, deleted_by VARCHAR(255) DEFAULT NULL, INDEX IDX_6DC501E5C35E566A (family_id), INDEX IDX_6DC501E52112FF29 (racer_id), INDEX IDX_6DC501E571F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, family_id INT NOT NULL, type VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, deleted_by VARCHAR(255) DEFAULT NULL, INDEX IDX_4C62E638C35E566A (family_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, startdate DATE NOT NULL, enddate DATE NOT NULL, title VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, memo VARCHAR(255) DEFAULT NULL, default_accomodation_location VARCHAR(255) DEFAULT NULL, default_skiday_location VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, deleted_by VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_racer (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, racer_id INT NOT NULL, validated TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, deleted_by VARCHAR(255) DEFAULT NULL, INDEX IDX_6BA19F7371F7E88B (event_id), INDEX IDX_6BA19F732112FF29 (racer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE family (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, adress1 VARCHAR(255) DEFAULT NULL, adress2 VARCHAR(255) DEFAULT NULL, codepos VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, deleted_by VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parameter (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, numeric_value DOUBLE PRECISION DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', textvalue LONGTEXT DEFAULT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, deleted_by VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pricetemplate (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, price DOUBLE PRECISION NOT NULL, skiday INT NOT NULL, accomodation INT NOT NULL, skipass INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, deleted_by VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE racer (id INT AUTO_INCREMENT NOT NULL, family_id INT NOT NULL, name VARCHAR(255) NOT NULL, sex VARCHAR(255) NOT NULL, birth_date DATE DEFAULT NULL, license_number VARCHAR(255) DEFAULT NULL, sntf TINYINT(1) NOT NULL, is_racer TINYINT(1) NOT NULL, is_ski_instructor TINYINT(1) NOT NULL, is_ski_coach TINYINT(1) NOT NULL, is_ski_instructor_location VARCHAR(255) DEFAULT NULL, license_activated TINYINT(1) NOT NULL, license_type VARCHAR(255) NOT NULL, club_activated TINYINT(1) NOT NULL, medical_activated TINYINT(1) NOT NULL, apply_activated TINYINT(1) NOT NULL, medical VARCHAR(255) DEFAULT NULL, size INT DEFAULT NULL, weight INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, deleted_by VARCHAR(255) DEFAULT NULL, INDEX IDX_2ABA2E5FC35E566A (family_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skiday (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, day_date DATE NOT NULL, location VARCHAR(255) DEFAULT NULL, day_type VARCHAR(255) NOT NULL, memo VARCHAR(255) DEFAULT NULL, skipass_youth_limit INT DEFAULT NULL, skipass_price DOUBLE PRECISION DEFAULT NULL, lunch_price DOUBLE PRECISION DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, deleted_by VARCHAR(255) DEFAULT NULL, INDEX IDX_8E59D09B71F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skiday_racer (id INT AUTO_INCREMENT NOT NULL, racer_id INT NOT NULL, skiday_id INT NOT NULL, training_racer TINYINT(1) NOT NULL, skipass_racer TINYINT(1) NOT NULL, skipass_nonracer_count INT NOT NULL, lunch_racer TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, deleted_by VARCHAR(255) DEFAULT NULL, INDEX IDX_3782DB82112FF29 (racer_id), INDEX IDX_3782DB8488BEE0 (skiday_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transport (id INT AUTO_INCREMENT NOT NULL, event_id INT DEFAULT NULL, direction VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, deleted_by VARCHAR(255) DEFAULT NULL, INDEX IDX_66AB212E71F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transport_racer (id INT AUTO_INCREMENT NOT NULL, transport_id INT NOT NULL, racer_id INT NOT NULL, racer_place TINYINT(1) NOT NULL, nonracer_place_count INT NOT NULL, available_place_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, deleted_by VARCHAR(255) DEFAULT NULL, INDEX IDX_B7B589A79909C13F (transport_id), INDEX IDX_B7B589A72112FF29 (racer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, deleted_by VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE accomodation ADD CONSTRAINT FK_520D81B371F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE accomodation_racer ADD CONSTRAINT FK_2D081839FD70509C FOREIGN KEY (accomodation_id) REFERENCES accomodation (id)');
        $this->addSql('ALTER TABLE accomodation_racer ADD CONSTRAINT FK_2D0818392112FF29 FOREIGN KEY (racer_id) REFERENCES racer (id)');
        $this->addSql('ALTER TABLE accounting ADD CONSTRAINT FK_6DC501E5C35E566A FOREIGN KEY (family_id) REFERENCES family (id)');
        $this->addSql('ALTER TABLE accounting ADD CONSTRAINT FK_6DC501E52112FF29 FOREIGN KEY (racer_id) REFERENCES racer (id)');
        $this->addSql('ALTER TABLE accounting ADD CONSTRAINT FK_6DC501E571F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638C35E566A FOREIGN KEY (family_id) REFERENCES family (id)');
        $this->addSql('ALTER TABLE event_racer ADD CONSTRAINT FK_6BA19F7371F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE event_racer ADD CONSTRAINT FK_6BA19F732112FF29 FOREIGN KEY (racer_id) REFERENCES racer (id)');
        $this->addSql('ALTER TABLE racer ADD CONSTRAINT FK_2ABA2E5FC35E566A FOREIGN KEY (family_id) REFERENCES family (id)');
        $this->addSql('ALTER TABLE skiday ADD CONSTRAINT FK_8E59D09B71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE skiday_racer ADD CONSTRAINT FK_3782DB82112FF29 FOREIGN KEY (racer_id) REFERENCES racer (id)');
        $this->addSql('ALTER TABLE skiday_racer ADD CONSTRAINT FK_3782DB8488BEE0 FOREIGN KEY (skiday_id) REFERENCES skiday (id)');
        $this->addSql('ALTER TABLE transport ADD CONSTRAINT FK_66AB212E71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE transport_racer ADD CONSTRAINT FK_B7B589A79909C13F FOREIGN KEY (transport_id) REFERENCES transport (id)');
        $this->addSql('ALTER TABLE transport_racer ADD CONSTRAINT FK_B7B589A72112FF29 FOREIGN KEY (racer_id) REFERENCES racer (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accomodation DROP FOREIGN KEY FK_520D81B371F7E88B');
        $this->addSql('ALTER TABLE accomodation_racer DROP FOREIGN KEY FK_2D081839FD70509C');
        $this->addSql('ALTER TABLE accomodation_racer DROP FOREIGN KEY FK_2D0818392112FF29');
        $this->addSql('ALTER TABLE accounting DROP FOREIGN KEY FK_6DC501E5C35E566A');
        $this->addSql('ALTER TABLE accounting DROP FOREIGN KEY FK_6DC501E52112FF29');
        $this->addSql('ALTER TABLE accounting DROP FOREIGN KEY FK_6DC501E571F7E88B');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638C35E566A');
        $this->addSql('ALTER TABLE event_racer DROP FOREIGN KEY FK_6BA19F7371F7E88B');
        $this->addSql('ALTER TABLE event_racer DROP FOREIGN KEY FK_6BA19F732112FF29');
        $this->addSql('ALTER TABLE racer DROP FOREIGN KEY FK_2ABA2E5FC35E566A');
        $this->addSql('ALTER TABLE skiday DROP FOREIGN KEY FK_8E59D09B71F7E88B');
        $this->addSql('ALTER TABLE skiday_racer DROP FOREIGN KEY FK_3782DB82112FF29');
        $this->addSql('ALTER TABLE skiday_racer DROP FOREIGN KEY FK_3782DB8488BEE0');
        $this->addSql('ALTER TABLE transport DROP FOREIGN KEY FK_66AB212E71F7E88B');
        $this->addSql('ALTER TABLE transport_racer DROP FOREIGN KEY FK_B7B589A79909C13F');
        $this->addSql('ALTER TABLE transport_racer DROP FOREIGN KEY FK_B7B589A72112FF29');
        $this->addSql('DROP TABLE accomodation');
        $this->addSql('DROP TABLE accomodation_racer');
        $this->addSql('DROP TABLE accounting');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_racer');
        $this->addSql('DROP TABLE family');
        $this->addSql('DROP TABLE parameter');
        $this->addSql('DROP TABLE pricetemplate');
        $this->addSql('DROP TABLE racer');
        $this->addSql('DROP TABLE skiday');
        $this->addSql('DROP TABLE skiday_racer');
        $this->addSql('DROP TABLE transport');
        $this->addSql('DROP TABLE transport_racer');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
