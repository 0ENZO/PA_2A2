<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200519093545 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE WAREHOUSES CHANGE ID_MAX_CAPACITY ID_MAX_CAPACITY INT DEFAULT NULL, CHANGE ID_ADRESSE ID_ADRESSE INT DEFAULT NULL');
        $this->addSql('ALTER TABLE MAINTENANCE_MANUALS CHANGE ID_TRUCK ID_TRUCK INT DEFAULT NULL');
        $this->addSql('ALTER TABLE SUB_CATEGORIES CHANGE ID_CATEGORY ID_CATEGORY INT DEFAULT NULL');
        $this->addSql('ALTER TABLE REWARD_CONTENTS DROP QUANTITY');
        $this->addSql('ALTER TABLE REWARD_CONTENTS RENAME INDEX idx_e66a1aa4e399e0cd TO IDX_776DCA4E399E0CD');
        $this->addSql('ALTER TABLE REWARD_CONTENTS RENAME INDEX fk_reward_contents TO IDX_776DCA48A1F78F');
        $this->addSql('ALTER TABLE CITIES CHANGE ID_DEPARTMENT ID_DEPARTMENT INT DEFAULT NULL');
        $this->addSql('ALTER TABLE FRANCHISES CHANGE ID_ADRESSE ID_ADRESSE INT DEFAULT NULL');
        $this->addSql('ALTER TABLE FRANCHISE_STOCKS DROP QUANTITY');
        $this->addSql('ALTER TABLE FRANCHISE_STOCKS RENAME INDEX idx_8dbd6df03cac38cd TO IDX_36D26BB23CAC38CD');
        $this->addSql('ALTER TABLE FRANCHISE_STOCKS RENAME INDEX fk_franchise_stocks TO IDX_36D26BB2FF3ED2B4');
        $this->addSql('ALTER TABLE PARTICIPATES RENAME INDEX idx_a6333c343cac38cd TO IDX_330175243CAC38CD');
        $this->addSql('ALTER TABLE PARTICIPATES RENAME INDEX fk_participates TO IDX_3301752414B4D2ED');
        $this->addSql('ALTER TABLE VOTES DROP NOTE, DROP COMMENT, DROP DATE, DROP TITLE_COMMENT');
        $this->addSql('ALTER TABLE VOTES RENAME INDEX idx_a6dfb87f3cac38cd TO IDX_518B7ACF3CAC38CD');
        $this->addSql('ALTER TABLE VOTES RENAME INDEX fk_votes TO IDX_518B7ACFF8371B55');
        $this->addSql('ALTER TABLE USERS CHANGE ID_ROLE ID_ROLE INT DEFAULT NULL');
        $this->addSql('ALTER TABLE CAN_CLAIM RENAME INDEX idx_9bd2b693f8371b55 TO IDX_D8BCAD4AF8371B55');
        $this->addSql('ALTER TABLE CAN_CLAIM RENAME INDEX fk_can_claim TO IDX_D8BCAD4AE399E0CD');
        $this->addSql('ALTER TABLE MENU CHANGE ID_FRANCHISE ID_FRANCHISE INT DEFAULT NULL');
        $this->addSql('ALTER TABLE CONCERNS RENAME INDEX idx_51866668a1f78f TO IDX_C32BFA2A8A1F78F');
        $this->addSql('ALTER TABLE CONCERNS RENAME INDEX fk_concerns TO IDX_C32BFA2A151D6013');
        $this->addSql('ALTER TABLE SALE_RECORDS CHANGE ID_FRANCHISE ID_FRANCHISE INT DEFAULT NULL');
        $this->addSql('ALTER TABLE CREDIT_CARDS CHANGE ID_USER ID_USER INT DEFAULT NULL');
        $this->addSql('ALTER TABLE TECHNICAL_CONTROLS CHANGE ID_TRUCK ID_TRUCK INT DEFAULT NULL');
        $this->addSql('ALTER TABLE USER_ORDERS CHANGE ID_USER ID_USER INT DEFAULT NULL');
        $this->addSql('ALTER TABLE CONTAINS RENAME INDEX idx_48c9f6322e4ed87f TO IDX_8EFA6A7E2E4ED87F');
        $this->addSql('ALTER TABLE CONTAINS RENAME INDEX fk_contains TO IDX_8EFA6A7E8A1F78F');
        $this->addSql('ALTER TABLE RECIPES DROP QUANTITY');
        $this->addSql('ALTER TABLE RECIPES RENAME INDEX idx_9c2c1caf2e4ed87f TO IDX_A369E2B52E4ED87F');
        $this->addSql('ALTER TABLE RECIPES RENAME INDEX fk_recipes TO IDX_A369E2B5FF3ED2B4');
        $this->addSql('ALTER TABLE WAREHOUSE_STOCKS DROP QUANTITY');
        $this->addSql('ALTER TABLE WAREHOUSE_STOCKS RENAME INDEX idx_8cc4136ff3ed2b4 TO IDX_B3A34774FF3ED2B4');
        $this->addSql('ALTER TABLE WAREHOUSE_STOCKS RENAME INDEX fk_warehouse_stocks TO IDX_B3A34774B6E97D1B');
        $this->addSql('ALTER TABLE BREAKDOWNS CHANGE ID_BREAKDOWN_TYPE ID_BREAKDOWN_TYPE INT DEFAULT NULL');
        $this->addSql('ALTER TABLE TRUCKS CHANGE ID_FRANCHISE ID_FRANCHISE INT DEFAULT NULL');
        $this->addSql('ALTER TABLE COULD_HAVE DROP DATE, DROP COMMENT');
        $this->addSql('ALTER TABLE COULD_HAVE RENAME INDEX idx_e2643224e2d62b40 TO IDX_283A001FE2D62B40');
        $this->addSql('ALTER TABLE COULD_HAVE RENAME INDEX fk_could_have TO IDX_283A001FE9CC6B40');
        $this->addSql('ALTER TABLE ADDRESSES CHANGE ID_CITY ID_CITY INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ALSO_LIVE_AT RENAME INDEX idx_81aef2c6ef2bde0f TO IDX_D5A79F60EF2BDE0F');
        $this->addSql('ALTER TABLE ALSO_LIVE_AT RENAME INDEX fk_also_live_at TO IDX_D5A79F60F8371B55');
        $this->addSql('ALTER TABLE FRANCHISE_ORDERS CHANGE ID_FRANCHISE ID_FRANCHISE INT DEFAULT NULL, CHANGE ID_WAREHOUSE ID_WAREHOUSE INT DEFAULT NULL');
        $this->addSql('ALTER TABLE FRANCHISE_ORDER_CONTENT DROP QUANTITY');
        $this->addSql('ALTER TABLE FRANCHISE_ORDER_CONTENT RENAME INDEX idx_5e83e60a9eaef9d0 TO IDX_4C6CD40C9EAEF9D0');
        $this->addSql('ALTER TABLE FRANCHISE_ORDER_CONTENT RENAME INDEX fk_franchise_order_content TO IDX_4C6CD40CFF3ED2B4');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ADDRESSES CHANGE ID_CITY ID_CITY INT NOT NULL');
        $this->addSql('ALTER TABLE also_live_at RENAME INDEX idx_d5a79f60f8371b55 TO FK_ALSO_LIVE_AT');
        $this->addSql('ALTER TABLE also_live_at RENAME INDEX idx_d5a79f60ef2bde0f TO IDX_81AEF2C6EF2BDE0F');
        $this->addSql('ALTER TABLE BREAKDOWNS CHANGE ID_BREAKDOWN_TYPE ID_BREAKDOWN_TYPE INT NOT NULL');
        $this->addSql('ALTER TABLE can_claim RENAME INDEX idx_d8bcad4ae399e0cd TO FK_CAN_CLAIM');
        $this->addSql('ALTER TABLE can_claim RENAME INDEX idx_d8bcad4af8371b55 TO IDX_9BD2B693F8371B55');
        $this->addSql('ALTER TABLE CITIES CHANGE ID_DEPARTMENT ID_DEPARTMENT INT NOT NULL');
        $this->addSql('ALTER TABLE concerns RENAME INDEX idx_c32bfa2a151d6013 TO FK_CONCERNS');
        $this->addSql('ALTER TABLE concerns RENAME INDEX idx_c32bfa2a8a1f78f TO IDX_51866668A1F78F');
        $this->addSql('ALTER TABLE contains RENAME INDEX idx_8efa6a7e8a1f78f TO FK_CONTAINS');
        $this->addSql('ALTER TABLE contains RENAME INDEX idx_8efa6a7e2e4ed87f TO IDX_48C9F6322E4ED87F');
        $this->addSql('ALTER TABLE could_have ADD DATE DATE NOT NULL, ADD COMMENT TEXT CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`');
        $this->addSql('ALTER TABLE could_have RENAME INDEX idx_283a001fe9cc6b40 TO FK_COULD_HAVE');
        $this->addSql('ALTER TABLE could_have RENAME INDEX idx_283a001fe2d62b40 TO IDX_E2643224E2D62B40');
        $this->addSql('ALTER TABLE CREDIT_CARDS CHANGE ID_USER ID_USER INT NOT NULL');
        $this->addSql('ALTER TABLE FRANCHISES CHANGE ID_ADRESSE ID_ADRESSE INT NOT NULL');
        $this->addSql('ALTER TABLE FRANCHISE_ORDERS CHANGE ID_FRANCHISE ID_FRANCHISE INT NOT NULL, CHANGE ID_WAREHOUSE ID_WAREHOUSE INT NOT NULL');
        $this->addSql('ALTER TABLE franchise_order_content ADD QUANTITY INT DEFAULT 1');
        $this->addSql('ALTER TABLE franchise_order_content RENAME INDEX idx_4c6cd40cff3ed2b4 TO FK_FRANCHISE_ORDER_CONTENT');
        $this->addSql('ALTER TABLE franchise_order_content RENAME INDEX idx_4c6cd40c9eaef9d0 TO IDX_5E83E60A9EAEF9D0');
        $this->addSql('ALTER TABLE franchise_stocks ADD QUANTITY INT NOT NULL');
        $this->addSql('ALTER TABLE franchise_stocks RENAME INDEX idx_36d26bb2ff3ed2b4 TO FK_FRANCHISE_STOCKS');
        $this->addSql('ALTER TABLE franchise_stocks RENAME INDEX idx_36d26bb23cac38cd TO IDX_8DBD6DF03CAC38CD');
        $this->addSql('ALTER TABLE MAINTENANCE_MANUALS CHANGE ID_TRUCK ID_TRUCK INT NOT NULL');
        $this->addSql('ALTER TABLE MENU CHANGE ID_FRANCHISE ID_FRANCHISE INT NOT NULL');
        $this->addSql('ALTER TABLE participates RENAME INDEX idx_3301752414b4d2ed TO FK_PARTICIPATES');
        $this->addSql('ALTER TABLE participates RENAME INDEX idx_330175243cac38cd TO IDX_A6333C343CAC38CD');
        $this->addSql('ALTER TABLE recipes ADD QUANTITY INT NOT NULL');
        $this->addSql('ALTER TABLE recipes RENAME INDEX idx_a369e2b5ff3ed2b4 TO FK_RECIPES');
        $this->addSql('ALTER TABLE recipes RENAME INDEX idx_a369e2b52e4ed87f TO IDX_9C2C1CAF2E4ED87F');
        $this->addSql('ALTER TABLE reward_contents ADD QUANTITY INT NOT NULL');
        $this->addSql('ALTER TABLE reward_contents RENAME INDEX idx_776dca48a1f78f TO FK_REWARD_CONTENTS');
        $this->addSql('ALTER TABLE reward_contents RENAME INDEX idx_776dca4e399e0cd TO IDX_E66A1AA4E399E0CD');
        $this->addSql('ALTER TABLE SALE_RECORDS CHANGE ID_FRANCHISE ID_FRANCHISE INT NOT NULL');
        $this->addSql('ALTER TABLE SUB_CATEGORIES CHANGE ID_CATEGORY ID_CATEGORY INT NOT NULL');
        $this->addSql('ALTER TABLE TECHNICAL_CONTROLS CHANGE ID_TRUCK ID_TRUCK INT NOT NULL');
        $this->addSql('ALTER TABLE TRUCKS CHANGE ID_FRANCHISE ID_FRANCHISE INT NOT NULL');
        $this->addSql('ALTER TABLE USERS CHANGE ID_ROLE ID_ROLE INT NOT NULL');
        $this->addSql('ALTER TABLE USER_ORDERS CHANGE ID_USER ID_USER INT NOT NULL');
        $this->addSql('ALTER TABLE votes ADD NOTE INT NOT NULL, ADD COMMENT TEXT CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, ADD DATE DATE NOT NULL, ADD TITLE_COMMENT VARCHAR(30) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`');
        $this->addSql('ALTER TABLE votes RENAME INDEX idx_518b7acff8371b55 TO FK_VOTES');
        $this->addSql('ALTER TABLE votes RENAME INDEX idx_518b7acf3cac38cd TO IDX_A6DFB87F3CAC38CD');
        $this->addSql('ALTER TABLE WAREHOUSES CHANGE ID_MAX_CAPACITY ID_MAX_CAPACITY INT NOT NULL, CHANGE ID_ADRESSE ID_ADRESSE INT NOT NULL');
        $this->addSql('ALTER TABLE warehouse_stocks ADD QUANTITY INT NOT NULL');
        $this->addSql('ALTER TABLE warehouse_stocks RENAME INDEX idx_b3a34774b6e97d1b TO FK_WAREHOUSE_STOCKS');
        $this->addSql('ALTER TABLE warehouse_stocks RENAME INDEX idx_b3a34774ff3ed2b4 TO IDX_8CC4136FF3ED2B4');
    }
}
