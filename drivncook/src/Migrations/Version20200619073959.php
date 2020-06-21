<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200619073959 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE event_franchise (event_id INT NOT NULL, franchise_id INT NOT NULL, INDEX IDX_E063F01771F7E88B (event_id), INDEX IDX_E063F017523CAB89 (franchise_id), PRIMARY KEY(event_id, franchise_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_article (menu_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_8AE113D8CCD7E912 (menu_id), INDEX IDX_8AE113D87294869C (article_id), PRIMARY KEY(menu_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reward_user (reward_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_8C8246D2E466ACA1 (reward_id), INDEX IDX_8C8246D2A76ED395 (user_id), PRIMARY KEY(reward_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event_franchise ADD CONSTRAINT FK_E063F01771F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_franchise ADD CONSTRAINT FK_E063F017523CAB89 FOREIGN KEY (franchise_id) REFERENCES franchise (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_article ADD CONSTRAINT FK_8AE113D8CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_article ADD CONSTRAINT FK_8AE113D87294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reward_user ADD CONSTRAINT FK_8C8246D2E466ACA1 FOREIGN KEY (reward_id) REFERENCES reward (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reward_user ADD CONSTRAINT FK_8C8246D2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE event_franchise');
        $this->addSql('DROP TABLE menu_article');
        $this->addSql('DROP TABLE reward_user');
    }
}
