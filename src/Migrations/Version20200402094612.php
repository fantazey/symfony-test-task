<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200402094612 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE car (id INT AUTO_INCREMENT NOT NULL, producer VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, year INT NOT NULL, vin VARCHAR(255) NOT NULL, color VARCHAR(255) NOT NULL, mileage INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE appraisal (id INT AUTO_INCREMENT NOT NULL, car_id INT DEFAULT NULL, average_price INT DEFAULT NULL, sale_price INT DEFAULT NULL, repair_price INT DEFAULT NULL, buyback_price INT DEFAULT NULL, type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_27EA2BD0C3C6F69F (car_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE similar_offer (id INT AUTO_INCREMENT NOT NULL, appraisal_id INT DEFAULT NULL, producer VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, year INT NOT NULL, color VARCHAR(255) NOT NULL, mileage INT NOT NULL, price INT NOT NULL, INDEX IDX_C4CE2D42DD670628 (appraisal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE appraisal ADD CONSTRAINT FK_27EA2BD0C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)');
        $this->addSql('ALTER TABLE similar_offer ADD CONSTRAINT FK_C4CE2D42DD670628 FOREIGN KEY (appraisal_id) REFERENCES appraisal (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE appraisal DROP FOREIGN KEY FK_27EA2BD0C3C6F69F');
        $this->addSql('ALTER TABLE similar_offer DROP FOREIGN KEY FK_C4CE2D42DD670628');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE appraisal');
        $this->addSql('DROP TABLE similar_offer');
    }
}
