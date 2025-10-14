<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251007230835 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accomodation DROP FOREIGN KEY FK_520D81B371F7E88B');
        $this->addSql('DROP INDEX IDX_520D81B371F7E88B ON accomodation');
        $this->addSql('ALTER TABLE accomodation DROP day_date, CHANGE event_id skiday_id INT NOT NULL');
        $this->addSql('ALTER TABLE accomodation ADD CONSTRAINT FK_520D81B3488BEE0 FOREIGN KEY (skiday_id) REFERENCES skiday (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_520D81B3488BEE0 ON accomodation (skiday_id)');
        $this->addSql('ALTER TABLE skiday ADD accomodation_id INT NOT NULL');
        $this->addSql('ALTER TABLE skiday ADD CONSTRAINT FK_8E59D09BFD70509C FOREIGN KEY (accomodation_id) REFERENCES accomodation (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8E59D09BFD70509C ON skiday (accomodation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accomodation DROP FOREIGN KEY FK_520D81B3488BEE0');
        $this->addSql('DROP INDEX UNIQ_520D81B3488BEE0 ON accomodation');
        $this->addSql('ALTER TABLE accomodation ADD day_date DATE NOT NULL, CHANGE skiday_id event_id INT NOT NULL');
        $this->addSql('ALTER TABLE accomodation ADD CONSTRAINT FK_520D81B371F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_520D81B371F7E88B ON accomodation (event_id)');
        $this->addSql('ALTER TABLE skiday DROP FOREIGN KEY FK_8E59D09BFD70509C');
        $this->addSql('DROP INDEX UNIQ_8E59D09BFD70509C ON skiday');
        $this->addSql('ALTER TABLE skiday DROP accomodation_id');
    }
}
