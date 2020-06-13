<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200613000001 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE credit_card (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, card_number VARCHAR(16) NOT NULL, expiration_date DATE NOT NULL, verification_code VARCHAR(3) NOT NULL, name VARCHAR(100) NOT NULL, INDEX IDX_11D627EEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE breakdown (id INT AUTO_INCREMENT NOT NULL, breakdown_type_id INT NOT NULL, statement VARCHAR(100) DEFAULT NULL, INDEX IDX_B3969DA73CB131D (breakdown_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE breakdown_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sale_record (id INT AUTO_INCREMENT NOT NULL, franchise_id INT NOT NULL, date DATE NOT NULL, total_expenses DOUBLE PRECISION NOT NULL, total_revenues DOUBLE PRECISION DEFAULT NULL, total_profits DOUBLE PRECISION DEFAULT NULL, total_vat DOUBLE PRECISION DEFAULT NULL, INDEX IDX_EF559153523CAB89 (franchise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE credit_card ADD CONSTRAINT FK_11D627EEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE breakdown ADD CONSTRAINT FK_B3969DA73CB131D FOREIGN KEY (breakdown_type_id) REFERENCES breakdown_type (id)');
        $this->addSql('ALTER TABLE sale_record ADD CONSTRAINT FK_EF559153523CAB89 FOREIGN KEY (franchise_id) REFERENCES franchise (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE breakdown DROP FOREIGN KEY FK_B3969DA73CB131D');
        $this->addSql('DROP TABLE credit_card');
        $this->addSql('DROP TABLE breakdown');
        $this->addSql('DROP TABLE breakdown_type');
        $this->addSql('DROP TABLE sale_record');
    }
}
