<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200708104607 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD euro_points_gap INT DEFAULT NULL, ADD formule_points_gap INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menu ADD euro_points_gap INT DEFAULT NULL, ADD formule_points_gap INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP euro_points_gap, DROP formule_points_gap');
        $this->addSql('ALTER TABLE menu DROP euro_points_gap, DROP formule_points_gap');
    }
}
