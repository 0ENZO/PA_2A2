<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200626092109 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE franchise_stock ADD franchise_id INT NOT NULL, ADD product_id INT NOT NULL, ADD quantity DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE franchise_stock ADD CONSTRAINT FK_DE4B34FF523CAB89 FOREIGN KEY (franchise_id) REFERENCES franchise (id)');
        $this->addSql('ALTER TABLE franchise_stock ADD CONSTRAINT FK_DE4B34FF4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_DE4B34FF523CAB89 ON franchise_stock (franchise_id)');
        $this->addSql('CREATE INDEX IDX_DE4B34FF4584665A ON franchise_stock (product_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE franchise_stock DROP FOREIGN KEY FK_DE4B34FF523CAB89');
        $this->addSql('ALTER TABLE franchise_stock DROP FOREIGN KEY FK_DE4B34FF4584665A');
        $this->addSql('DROP INDEX IDX_DE4B34FF523CAB89 ON franchise_stock');
        $this->addSql('DROP INDEX IDX_DE4B34FF4584665A ON franchise_stock');
        $this->addSql('ALTER TABLE franchise_stock DROP franchise_id, DROP product_id, DROP quantity');
    }
}
