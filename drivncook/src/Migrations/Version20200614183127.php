<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200614183127 extends AbstractMigration
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
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, address_id INT NOT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT DEFAULT NULL, date_begin DATETIME NOT NULL, date_end DATETIME NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_3BAE0AA7F5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vote (id INT AUTO_INCREMENT NOT NULL, franchise_id INT NOT NULL, user_id INT NOT NULL, rate SMALLINT DEFAULT NULL, comment LONGTEXT DEFAULT NULL, date DATETIME NOT NULL, title_comment VARCHAR(50) DEFAULT NULL, INDEX IDX_5A108564523CAB89 (franchise_id), INDEX IDX_5A108564A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, description LONGTEXT DEFAULT NULL, price DOUBLE PRECISION NOT NULL, status VARCHAR(50) DEFAULT NULL, vat DOUBLE PRECISION NOT NULL, expiry_date DATE NOT NULL, quantity SMALLINT NOT NULL, INDEX IDX_D34A04AD12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE franchise_order_content (id INT AUTO_INCREMENT NOT NULL, franchise_order_id INT NOT NULL, product_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_4C6CD40C2AF96C4 (franchise_order_id), INDEX IDX_4C6CD40C4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE max_capacity (id INT AUTO_INCREMENT NOT NULL, max_ingredients SMALLINT NOT NULL, max_drinks SMALLINT NOT NULL, max_desserts SMALLINT NOT NULL, max_meals SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, department_id INT NOT NULL, name VARCHAR(255) NOT NULL, postal_code VARCHAR(5) NOT NULL, INDEX IDX_2D5B0234AE80F5DF (department_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, city_id INT NOT NULL, street VARCHAR(100) NOT NULL, number INT NOT NULL, number_complement INT DEFAULT NULL, INDEX IDX_D4E6F818BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE credit_card (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, card_number VARCHAR(16) NOT NULL, expiration_date DATE NOT NULL, verification_code VARCHAR(3) NOT NULL, name VARCHAR(100) NOT NULL, INDEX IDX_11D627EEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, role_id INT DEFAULT NULL, address_id INT DEFAULT NULL, pseudo VARCHAR(30) NOT NULL, first_name VARCHAR(50) DEFAULT NULL, last_name VARCHAR(50) DEFAULT NULL, email VARCHAR(200) NOT NULL, phone_number VARCHAR(10) DEFAULT NULL, euro_points SMALLINT DEFAULT NULL, formule_points SMALLINT DEFAULT NULL, is_activated TINYINT(1) DEFAULT NULL, password VARCHAR(255) NOT NULL, birth_date DATETIME NOT NULL, INDEX IDX_8D93D649D60322AC (role_id), INDEX IDX_8D93D649F5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE breakdown (id INT AUTO_INCREMENT NOT NULL, breakdown_type_id INT NOT NULL, statement VARCHAR(100) DEFAULT NULL, INDEX IDX_B3969DA73CB131D (breakdown_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE franchise_order (id INT AUTO_INCREMENT NOT NULL, franchise_id INT NOT NULL, warehouse_id INT NOT NULL, comment LONGTEXT DEFAULT NULL, date DATETIME NOT NULL, status VARCHAR(50) DEFAULT NULL, total_price DOUBLE PRECISION NOT NULL, INDEX IDX_6054F107523CAB89 (franchise_id), INDEX IDX_6054F1075080ECDE (warehouse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reward_content (id INT AUTO_INCREMENT NOT NULL, reward_id INT NOT NULL, menu_id INT NOT NULL, quantity SMALLINT NOT NULL, INDEX IDX_1472CD51E466ACA1 (reward_id), INDEX IDX_1472CD51CCD7E912 (menu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE breakdown_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, franchise_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, description LONGTEXT DEFAULT NULL, price DOUBLE PRECISION NOT NULL, vat DOUBLE PRECISION NOT NULL, INDEX IDX_7D053A93523CAB89 (franchise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE department (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maintenance_manual (id INT AUTO_INCREMENT NOT NULL, truck_id INT NOT NULL, immatriculation VARCHAR(20) NOT NULL, mileage SMALLINT NOT NULL, insurance VARCHAR(30) NOT NULL, age SMALLINT NOT NULL, comment LONGTEXT DEFAULT NULL, date DATE DEFAULT NULL, INDEX IDX_3A2688CDC6957CCE (truck_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_order_content (id INT AUTO_INCREMENT NOT NULL, user_order_id INT NOT NULL, article_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_E63134B26D128938 (user_order_id), INDEX IDX_E63134B27294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE warehouse_stock (id INT AUTO_INCREMENT NOT NULL, warehouse_id INT NOT NULL, product_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_CA572AAD5080ECDE (warehouse_id), INDEX IDX_CA572AAD4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE franchise (id INT AUTO_INCREMENT NOT NULL, role_id INT NOT NULL, address_id INT DEFAULT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, email VARCHAR(200) NOT NULL, password VARCHAR(255) NOT NULL, INDEX IDX_66F6CE2AD60322AC (role_id), INDEX IDX_66F6CE2AF5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE warehouse (id INT AUTO_INCREMENT NOT NULL, address_id INT NOT NULL, max_capacity_id INT NOT NULL, name VARCHAR(50) NOT NULL, email VARCHAR(200) NOT NULL, phone_number VARCHAR(10) NOT NULL, INDEX IDX_ECB38BFCF5B7AF75 (address_id), INDEX IDX_ECB38BFCDB187195 (max_capacity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sub_category (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(50) NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_BCE3F79812469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technical_control (id INT AUTO_INCREMENT NOT NULL, truck_id INT NOT NULL, date DATE NOT NULL, comment LONGTEXT DEFAULT NULL, INDEX IDX_819789FAC6957CCE (truck_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE truck (id INT AUTO_INCREMENT NOT NULL, franchise_id INT DEFAULT NULL, max_capacity_id INT NOT NULL, brand VARCHAR(50) NOT NULL, model VARCHAR(50) NOT NULL, status VARCHAR(50) DEFAULT NULL, factory_date DATE NOT NULL, INDEX IDX_CDCCF30A523CAB89 (franchise_id), INDEX IDX_CDCCF30ADB187195 (max_capacity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reward (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, minimal_points VARCHAR(11) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, description LONGTEXT DEFAULT NULL, price DOUBLE PRECISION NOT NULL, vat DOUBLE PRECISION NOT NULL, INDEX IDX_23A0E6612469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_order (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, comment LONGTEXT DEFAULT NULL, date DATETIME NOT NULL, status VARCHAR(50) DEFAULT NULL, INDEX IDX_17EB68C0A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, product_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_DA88B1377294869C (article_id), INDEX IDX_DA88B1374584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sale_record (id INT AUTO_INCREMENT NOT NULL, franchise_id INT NOT NULL, date DATE NOT NULL, total_expenses DOUBLE PRECISION NOT NULL, total_revenues DOUBLE PRECISION DEFAULT NULL, total_profits DOUBLE PRECISION DEFAULT NULL, total_vat DOUBLE PRECISION DEFAULT NULL, INDEX IDX_EF559153523CAB89 (franchise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564523CAB89 FOREIGN KEY (franchise_id) REFERENCES franchise (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE franchise_order_content ADD CONSTRAINT FK_4C6CD40C2AF96C4 FOREIGN KEY (franchise_order_id) REFERENCES franchise_order (id)');
        $this->addSql('ALTER TABLE franchise_order_content ADD CONSTRAINT FK_4C6CD40C4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B0234AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id)');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F818BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE credit_card ADD CONSTRAINT FK_11D627EEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE breakdown ADD CONSTRAINT FK_B3969DA73CB131D FOREIGN KEY (breakdown_type_id) REFERENCES breakdown_type (id)');
        $this->addSql('ALTER TABLE franchise_order ADD CONSTRAINT FK_6054F107523CAB89 FOREIGN KEY (franchise_id) REFERENCES franchise (id)');
        $this->addSql('ALTER TABLE franchise_order ADD CONSTRAINT FK_6054F1075080ECDE FOREIGN KEY (warehouse_id) REFERENCES warehouse (id)');
        $this->addSql('ALTER TABLE reward_content ADD CONSTRAINT FK_1472CD51E466ACA1 FOREIGN KEY (reward_id) REFERENCES reward (id)');
        $this->addSql('ALTER TABLE reward_content ADD CONSTRAINT FK_1472CD51CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A93523CAB89 FOREIGN KEY (franchise_id) REFERENCES franchise (id)');
        $this->addSql('ALTER TABLE maintenance_manual ADD CONSTRAINT FK_3A2688CDC6957CCE FOREIGN KEY (truck_id) REFERENCES truck (id)');
        $this->addSql('ALTER TABLE user_order_content ADD CONSTRAINT FK_E63134B26D128938 FOREIGN KEY (user_order_id) REFERENCES user_order (id)');
        $this->addSql('ALTER TABLE user_order_content ADD CONSTRAINT FK_E63134B27294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE warehouse_stock ADD CONSTRAINT FK_CA572AAD5080ECDE FOREIGN KEY (warehouse_id) REFERENCES warehouse (id)');
        $this->addSql('ALTER TABLE warehouse_stock ADD CONSTRAINT FK_CA572AAD4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE franchise ADD CONSTRAINT FK_66F6CE2AD60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE franchise ADD CONSTRAINT FK_66F6CE2AF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE warehouse ADD CONSTRAINT FK_ECB38BFCF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE warehouse ADD CONSTRAINT FK_ECB38BFCDB187195 FOREIGN KEY (max_capacity_id) REFERENCES max_capacity (id)');
        $this->addSql('ALTER TABLE sub_category ADD CONSTRAINT FK_BCE3F79812469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE technical_control ADD CONSTRAINT FK_819789FAC6957CCE FOREIGN KEY (truck_id) REFERENCES truck (id)');
        $this->addSql('ALTER TABLE truck ADD CONSTRAINT FK_CDCCF30A523CAB89 FOREIGN KEY (franchise_id) REFERENCES franchise (id)');
        $this->addSql('ALTER TABLE truck ADD CONSTRAINT FK_CDCCF30ADB187195 FOREIGN KEY (max_capacity_id) REFERENCES max_capacity (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6612469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE user_order ADD CONSTRAINT FK_17EB68C0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B1377294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B1374584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE sale_record ADD CONSTRAINT FK_EF559153523CAB89 FOREIGN KEY (franchise_id) REFERENCES franchise (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE sub_category DROP FOREIGN KEY FK_BCE3F79812469DE2');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6612469DE2');
        $this->addSql('ALTER TABLE franchise_order_content DROP FOREIGN KEY FK_4C6CD40C4584665A');
        $this->addSql('ALTER TABLE warehouse_stock DROP FOREIGN KEY FK_CA572AAD4584665A');
        $this->addSql('ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B1374584665A');
        $this->addSql('ALTER TABLE warehouse DROP FOREIGN KEY FK_ECB38BFCDB187195');
        $this->addSql('ALTER TABLE truck DROP FOREIGN KEY FK_CDCCF30ADB187195');
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F818BAC62AF');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7F5B7AF75');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F5B7AF75');
        $this->addSql('ALTER TABLE franchise DROP FOREIGN KEY FK_66F6CE2AF5B7AF75');
        $this->addSql('ALTER TABLE warehouse DROP FOREIGN KEY FK_ECB38BFCF5B7AF75');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564A76ED395');
        $this->addSql('ALTER TABLE credit_card DROP FOREIGN KEY FK_11D627EEA76ED395');
        $this->addSql('ALTER TABLE user_order DROP FOREIGN KEY FK_17EB68C0A76ED395');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D60322AC');
        $this->addSql('ALTER TABLE franchise DROP FOREIGN KEY FK_66F6CE2AD60322AC');
        $this->addSql('ALTER TABLE franchise_order_content DROP FOREIGN KEY FK_4C6CD40C2AF96C4');
        $this->addSql('ALTER TABLE breakdown DROP FOREIGN KEY FK_B3969DA73CB131D');
        $this->addSql('ALTER TABLE reward_content DROP FOREIGN KEY FK_1472CD51CCD7E912');
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B0234AE80F5DF');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564523CAB89');
        $this->addSql('ALTER TABLE franchise_order DROP FOREIGN KEY FK_6054F107523CAB89');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A93523CAB89');
        $this->addSql('ALTER TABLE truck DROP FOREIGN KEY FK_CDCCF30A523CAB89');
        $this->addSql('ALTER TABLE sale_record DROP FOREIGN KEY FK_EF559153523CAB89');
        $this->addSql('ALTER TABLE franchise_order DROP FOREIGN KEY FK_6054F1075080ECDE');
        $this->addSql('ALTER TABLE warehouse_stock DROP FOREIGN KEY FK_CA572AAD5080ECDE');
        $this->addSql('ALTER TABLE maintenance_manual DROP FOREIGN KEY FK_3A2688CDC6957CCE');
        $this->addSql('ALTER TABLE technical_control DROP FOREIGN KEY FK_819789FAC6957CCE');
        $this->addSql('ALTER TABLE reward_content DROP FOREIGN KEY FK_1472CD51E466ACA1');
        $this->addSql('ALTER TABLE user_order_content DROP FOREIGN KEY FK_E63134B27294869C');
        $this->addSql('ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B1377294869C');
        $this->addSql('ALTER TABLE user_order_content DROP FOREIGN KEY FK_E63134B26D128938');
        $this->addSql('DROP TABLE franchise_stock');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE vote');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE franchise_order_content');
        $this->addSql('DROP TABLE max_capacity');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE credit_card');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE breakdown');
        $this->addSql('DROP TABLE franchise_order');
        $this->addSql('DROP TABLE reward_content');
        $this->addSql('DROP TABLE breakdown_type');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE department');
        $this->addSql('DROP TABLE maintenance_manual');
        $this->addSql('DROP TABLE user_order_content');
        $this->addSql('DROP TABLE warehouse_stock');
        $this->addSql('DROP TABLE franchise');
        $this->addSql('DROP TABLE warehouse');
        $this->addSql('DROP TABLE sub_category');
        $this->addSql('DROP TABLE technical_control');
        $this->addSql('DROP TABLE truck');
        $this->addSql('DROP TABLE reward');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE user_order');
        $this->addSql('DROP TABLE recipe');
        $this->addSql('DROP TABLE sale_record');
    }
}
