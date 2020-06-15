<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200615224024 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE category ADD image_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD image_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('DROP INDEX IDX_D34A04AD12469DE2 ON product');
        $this->addSql('ALTER TABLE product ADD image_name VARCHAR(255) DEFAULT NULL, CHANGE expiry_date expiry_date DATE DEFAULT NULL, CHANGE category_id sub_category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADF7BFE87C FOREIGN KEY (sub_category_id) REFERENCES sub_category (id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADF7BFE87C ON product (sub_category_id)');
        $this->addSql('ALTER TABLE credit_card ADD franchise_id INT NOT NULL');
        $this->addSql('ALTER TABLE credit_card ADD CONSTRAINT FK_11D627EE523CAB89 FOREIGN KEY (franchise_id) REFERENCES franchise (id)');
        $this->addSql('CREATE INDEX IDX_11D627EE523CAB89 ON credit_card (franchise_id)');
        $this->addSql('ALTER TABLE user ADD image_name VARCHAR(255) DEFAULT NULL, CHANGE euro_points euro_points VARCHAR(11) DEFAULT NULL, CHANGE formule_points formule_points VARCHAR(11) DEFAULT NULL, CHANGE birth_date birth_date DATE NOT NULL');
        $this->addSql('ALTER TABLE franchise_order ADD document_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE maintenance_manual ADD image_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE franchise ADD phone_number VARCHAR(10) DEFAULT NULL, ADD image_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE sub_category ADD image_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6612469DE2');
        $this->addSql('DROP INDEX IDX_23A0E6612469DE2 ON article');
        $this->addSql('ALTER TABLE article ADD image_name VARCHAR(255) DEFAULT NULL, CHANGE category_id sub_category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66F7BFE87C FOREIGN KEY (sub_category_id) REFERENCES sub_category (id)');
        $this->addSql('CREATE INDEX IDX_23A0E66F7BFE87C ON article (sub_category_id)');
        $this->addSql('ALTER TABLE sale_record CHANGE date date DATE DEFAULT NULL, CHANGE total_expenses total_expenses DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66F7BFE87C');
        $this->addSql('DROP INDEX IDX_23A0E66F7BFE87C ON article');
        $this->addSql('ALTER TABLE article DROP image_name, CHANGE sub_category_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6612469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_23A0E6612469DE2 ON article (category_id)');
        $this->addSql('ALTER TABLE category DROP image_name');
        $this->addSql('ALTER TABLE credit_card DROP FOREIGN KEY FK_11D627EE523CAB89');
        $this->addSql('DROP INDEX IDX_11D627EE523CAB89 ON credit_card');
        $this->addSql('ALTER TABLE credit_card DROP franchise_id');
        $this->addSql('ALTER TABLE event DROP image_name');
        $this->addSql('ALTER TABLE franchise DROP phone_number, DROP image_name');
        $this->addSql('ALTER TABLE franchise_order DROP document_name');
        $this->addSql('ALTER TABLE maintenance_manual DROP image_name');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADF7BFE87C');
        $this->addSql('DROP INDEX IDX_D34A04ADF7BFE87C ON product');
        $this->addSql('ALTER TABLE product DROP image_name, CHANGE expiry_date expiry_date DATE NOT NULL, CHANGE sub_category_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD12469DE2 ON product (category_id)');
        $this->addSql('ALTER TABLE sale_record CHANGE date date DATE NOT NULL, CHANGE total_expenses total_expenses DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE sub_category DROP image_name');
        $this->addSql('ALTER TABLE user DROP image_name, CHANGE euro_points euro_points SMALLINT DEFAULT NULL, CHANGE formule_points formule_points SMALLINT DEFAULT NULL, CHANGE birth_date birth_date DATETIME NOT NULL');
    }
}
