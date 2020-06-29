<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200629150612 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE answer_report_breakdown (id INT AUTO_INCREMENT NOT NULL, report_breakdown_id INT NOT NULL, user_id INT NOT NULL, content LONGTEXT DEFAULT NULL, date DATETIME NOT NULL, INDEX IDX_7E7C8FCA699FDCD9 (report_breakdown_id), INDEX IDX_7E7C8FCAA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE answer_report_breakdown ADD CONSTRAINT FK_7E7C8FCA699FDCD9 FOREIGN KEY (report_breakdown_id) REFERENCES report_breakdown (id)');
        $this->addSql('ALTER TABLE answer_report_breakdown ADD CONSTRAINT FK_7E7C8FCAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE report_breakdown ADD status VARCHAR(50) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE answer_report_breakdown');
        $this->addSql('ALTER TABLE report_breakdown DROP status');
    }
}
