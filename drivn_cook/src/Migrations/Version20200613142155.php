<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200613142155 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE city CHANGE postal_code postal_code VARCHAR(5) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE phone_number phone_number VARCHAR(10) DEFAULT NULL');
        $this->addSql('ALTER TABLE warehouse CHANGE phone_number phone_number VARCHAR(10) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE city CHANGE postal_code postal_code SMALLINT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE phone_number phone_number SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE warehouse CHANGE phone_number phone_number SMALLINT NOT NULL');
    }
}
