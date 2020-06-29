<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200628151153 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE report_breakdown (id INT AUTO_INCREMENT NOT NULL, truck_id INT NOT NULL, breakdown_id INT NOT NULL, description LONGTEXT DEFAULT NULL, date DATETIME NOT NULL, phone_number VARCHAR(10) DEFAULT NULL, image_name VARCHAR(255) DEFAULT NULL, UploadDate DATETIME DEFAULT NULL, INDEX IDX_9D22F0BFC6957CCE (truck_id), INDEX IDX_9D22F0BF67F54C40 (breakdown_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE report_breakdown ADD CONSTRAINT FK_9D22F0BFC6957CCE FOREIGN KEY (truck_id) REFERENCES truck (id)');
        $this->addSql('ALTER TABLE report_breakdown ADD CONSTRAINT FK_9D22F0BF67F54C40 FOREIGN KEY (breakdown_id) REFERENCES breakdown (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE report_breakdown');
    }
}
