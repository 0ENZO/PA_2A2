<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200613005620 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE franchise_stock (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vote (id INT AUTO_INCREMENT NOT NULL, franchise_id INT NOT NULL, user_id INT NOT NULL, rate SMALLINT DEFAULT NULL, comment LONGTEXT DEFAULT NULL, date DATETIME NOT NULL, title_comment VARCHAR(50) DEFAULT NULL, INDEX IDX_5A108564523CAB89 (franchise_id), INDEX IDX_5A108564A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE franchise_order_content (id INT AUTO_INCREMENT NOT NULL, franchise_order_id INT NOT NULL, product_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_4C6CD40C2AF96C4 (franchise_order_id), INDEX IDX_4C6CD40C4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE credit_card (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, card_number VARCHAR(16) NOT NULL, expiration_date DATE NOT NULL, verification_code VARCHAR(3) NOT NULL, name VARCHAR(100) NOT NULL, INDEX IDX_11D627EEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE breakdown (id INT AUTO_INCREMENT NOT NULL, breakdown_type_id INT NOT NULL, statement VARCHAR(100) DEFAULT NULL, INDEX IDX_B3969DA73CB131D (breakdown_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reward_content (id INT AUTO_INCREMENT NOT NULL, reward_id INT NOT NULL, menu_id INT NOT NULL, quantity SMALLINT NOT NULL, INDEX IDX_1472CD51E466ACA1 (reward_id), INDEX IDX_1472CD51CCD7E912 (menu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE breakdown_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, franchise_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, description LONGTEXT DEFAULT NULL, price DOUBLE PRECISION NOT NULL, vat DOUBLE PRECISION NOT NULL, INDEX IDX_7D053A93523CAB89 (franchise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maintenance_manual (id INT AUTO_INCREMENT NOT NULL, truck_id INT NOT NULL, immatriculation VARCHAR(20) NOT NULL, mileage SMALLINT NOT NULL, insurance VARCHAR(30) NOT NULL, age SMALLINT NOT NULL, comment LONGTEXT DEFAULT NULL, date DATE DEFAULT NULL, INDEX IDX_3A2688CDC6957CCE (truck_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_order_content (id INT AUTO_INCREMENT NOT NULL, user_order_id INT NOT NULL, article_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_E63134B26D128938 (user_order_id), INDEX IDX_E63134B27294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE warehouse_stock (id INT AUTO_INCREMENT NOT NULL, warehouse_id INT NOT NULL, product_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_CA572AAD5080ECDE (warehouse_id), INDEX IDX_CA572AAD4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technical_control (id INT AUTO_INCREMENT NOT NULL, truck_id INT NOT NULL, date DATE NOT NULL, comment LONGTEXT DEFAULT NULL, INDEX IDX_819789FAC6957CCE (truck_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reward (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, minimal_points VARCHAR(11) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_order (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, comment LONGTEXT DEFAULT NULL, date DATETIME NOT NULL, status VARCHAR(50) DEFAULT NULL, INDEX IDX_17EB68C0A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, product_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_DA88B1377294869C (article_id), INDEX IDX_DA88B1374584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sale_record (id INT AUTO_INCREMENT NOT NULL, franchise_id INT NOT NULL, date DATE NOT NULL, total_expenses DOUBLE PRECISION NOT NULL, total_revenues DOUBLE PRECISION DEFAULT NULL, total_profits DOUBLE PRECISION DEFAULT NULL, total_vat DOUBLE PRECISION DEFAULT NULL, INDEX IDX_EF559153523CAB89 (franchise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564523CAB89 FOREIGN KEY (franchise_id) REFERENCES franchise (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE franchise_order_content ADD CONSTRAINT FK_4C6CD40C2AF96C4 FOREIGN KEY (franchise_order_id) REFERENCES franchise_order (id)');
        $this->addSql('ALTER TABLE franchise_order_content ADD CONSTRAINT FK_4C6CD40C4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE credit_card ADD CONSTRAINT FK_11D627EEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE breakdown ADD CONSTRAINT FK_B3969DA73CB131D FOREIGN KEY (breakdown_type_id) REFERENCES breakdown_type (id)');
        $this->addSql('ALTER TABLE reward_content ADD CONSTRAINT FK_1472CD51E466ACA1 FOREIGN KEY (reward_id) REFERENCES reward (id)');
        $this->addSql('ALTER TABLE reward_content ADD CONSTRAINT FK_1472CD51CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A93523CAB89 FOREIGN KEY (franchise_id) REFERENCES franchise (id)');
        $this->addSql('ALTER TABLE maintenance_manual ADD CONSTRAINT FK_3A2688CDC6957CCE FOREIGN KEY (truck_id) REFERENCES truck (id)');
        $this->addSql('ALTER TABLE user_order_content ADD CONSTRAINT FK_E63134B26D128938 FOREIGN KEY (user_order_id) REFERENCES user_order (id)');
        $this->addSql('ALTER TABLE user_order_content ADD CONSTRAINT FK_E63134B27294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE warehouse_stock ADD CONSTRAINT FK_CA572AAD5080ECDE FOREIGN KEY (warehouse_id) REFERENCES warehouse (id)');
        $this->addSql('ALTER TABLE warehouse_stock ADD CONSTRAINT FK_CA572AAD4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE technical_control ADD CONSTRAINT FK_819789FAC6957CCE FOREIGN KEY (truck_id) REFERENCES truck (id)');
        $this->addSql('ALTER TABLE user_order ADD CONSTRAINT FK_17EB68C0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B1377294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B1374584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE sale_record ADD CONSTRAINT FK_EF559153523CAB89 FOREIGN KEY (franchise_id) REFERENCES franchise (id)');
        $this->addSql('DROP TABLE franchise_order_product');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE breakdown DROP FOREIGN KEY FK_B3969DA73CB131D');
        $this->addSql('ALTER TABLE reward_content DROP FOREIGN KEY FK_1472CD51CCD7E912');
        $this->addSql('ALTER TABLE reward_content DROP FOREIGN KEY FK_1472CD51E466ACA1');
        $this->addSql('ALTER TABLE user_order_content DROP FOREIGN KEY FK_E63134B26D128938');
        $this->addSql('CREATE TABLE franchise_order_product (franchise_order_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_61E3E0082AF96C4 (franchise_order_id), INDEX IDX_61E3E0084584665A (product_id), PRIMARY KEY(franchise_order_id, product_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE franchise_order_product ADD CONSTRAINT FK_61E3E0082AF96C4 FOREIGN KEY (franchise_order_id) REFERENCES franchise_order (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE franchise_order_product ADD CONSTRAINT FK_61E3E0084584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE franchise_stock');
        $this->addSql('DROP TABLE vote');
        $this->addSql('DROP TABLE franchise_order_content');
        $this->addSql('DROP TABLE credit_card');
        $this->addSql('DROP TABLE breakdown');
        $this->addSql('DROP TABLE reward_content');
        $this->addSql('DROP TABLE breakdown_type');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE maintenance_manual');
        $this->addSql('DROP TABLE user_order_content');
        $this->addSql('DROP TABLE warehouse_stock');
        $this->addSql('DROP TABLE technical_control');
        $this->addSql('DROP TABLE reward');
        $this->addSql('DROP TABLE user_order');
        $this->addSql('DROP TABLE recipe');
        $this->addSql('DROP TABLE sale_record');
    }
}
