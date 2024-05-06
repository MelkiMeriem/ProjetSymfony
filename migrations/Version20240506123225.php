<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240506123225 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE campaigns (id INT AUTO_INCREMENT NOT NULL, owner_id_id INT DEFAULT NULL, campaign_name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, budget DOUBLE PRECISION DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, INDEX IDX_E37374708FDDAB70 (owner_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE campaigns ADD CONSTRAINT FK_E37374708FDDAB70 FOREIGN KEY (owner_id_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE campaigns DROP FOREIGN KEY FK_E37374708FDDAB70');
        $this->addSql('DROP TABLE campaigns');
    }
}
