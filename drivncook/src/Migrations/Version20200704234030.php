<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200704234030 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_order_content ADD menu_id INT DEFAULT NULL, CHANGE article_id article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_order_content ADD CONSTRAINT FK_E63134B2CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('CREATE INDEX IDX_E63134B2CCD7E912 ON user_order_content (menu_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_order_content DROP FOREIGN KEY FK_E63134B2CCD7E912');
        $this->addSql('DROP INDEX IDX_E63134B2CCD7E912 ON user_order_content');
        $this->addSql('ALTER TABLE user_order_content DROP menu_id, CHANGE article_id article_id INT NOT NULL');
    }
}
