<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200705105110 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_order ADD complete_address VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user_order_content DROP FOREIGN KEY FK_E63134B27294869C');
        $this->addSql('DROP INDEX IDX_E63134B27294869C ON user_order_content');
        $this->addSql('ALTER TABLE user_order_content DROP article_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_order DROP complete_address');
        $this->addSql('ALTER TABLE user_order_content ADD article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_order_content ADD CONSTRAINT FK_E63134B27294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_E63134B27294869C ON user_order_content (article_id)');
    }
}
