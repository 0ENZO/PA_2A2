<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200623130150 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE max_capacity CHANGE max_ingredients max_ingredients INT NOT NULL, CHANGE max_drinks max_drinks INT NOT NULL, CHANGE max_desserts max_desserts INT NOT NULL, CHANGE max_meals max_meals INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE max_capacity CHANGE max_ingredients max_ingredients SMALLINT NOT NULL, CHANGE max_drinks max_drinks SMALLINT NOT NULL, CHANGE max_desserts max_desserts SMALLINT NOT NULL, CHANGE max_meals max_meals SMALLINT NOT NULL');
    }
}
