<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200402205423 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE appraisal CHANGE sale_price sale_price INT NOT NULL, CHANGE repair_price repair_price INT NOT NULL');
        $this->addSql('ALTER TABLE similar_offer DROP FOREIGN KEY FK_C4CE2D42DD670628');
        $this->addSql('DROP INDEX IDX_C4CE2D42DD670628 ON similar_offer');
        $this->addSql('ALTER TABLE similar_offer CHANGE appraisal_id car_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE similar_offer ADD CONSTRAINT FK_C4CE2D42C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)');
        $this->addSql('CREATE INDEX IDX_C4CE2D42C3C6F69F ON similar_offer (car_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE appraisal CHANGE sale_price sale_price INT DEFAULT NULL, CHANGE repair_price repair_price INT DEFAULT NULL');
        $this->addSql('ALTER TABLE similar_offer DROP FOREIGN KEY FK_C4CE2D42C3C6F69F');
        $this->addSql('DROP INDEX IDX_C4CE2D42C3C6F69F ON similar_offer');
        $this->addSql('ALTER TABLE similar_offer CHANGE car_id appraisal_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE similar_offer ADD CONSTRAINT FK_C4CE2D42DD670628 FOREIGN KEY (appraisal_id) REFERENCES appraisal (id)');
        $this->addSql('CREATE INDEX IDX_C4CE2D42DD670628 ON similar_offer (appraisal_id)');
    }
}
