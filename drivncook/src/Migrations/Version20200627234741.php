<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200627234741 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD status VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE event ADD complete_address VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE franchise ADD complete_address VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE truck ADD complete_address VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD complete_address VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP status');
        $this->addSql('ALTER TABLE event DROP complete_address');
        $this->addSql('ALTER TABLE franchise DROP complete_address');
        $this->addSql('ALTER TABLE truck DROP complete_address');
        $this->addSql('ALTER TABLE user DROP complete_address');
    }
}
