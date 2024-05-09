<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240509180037 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE campaigns (id INT AUTO_INCREMENT NOT NULL, owner_id_id INT DEFAULT NULL, campaign_name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, budget DOUBLE PRECISION DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, INDEX IDX_E37374708FDDAB70 (owner_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fund (id INT AUTO_INCREMENT NOT NULL, campain_id_id INT NOT NULL, user_id_id INT NOT NULL, user_email VARCHAR(255) NOT NULL, user_password VARCHAR(50) NOT NULL, amount INT NOT NULL, date DATE DEFAULT NULL, INDEX IDX_DC923E1079384475 (campain_id_id), INDEX IDX_DC923E109D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, fullname VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE campaigns ADD CONSTRAINT FK_E37374708FDDAB70 FOREIGN KEY (owner_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE fund ADD CONSTRAINT FK_DC923E1079384475 FOREIGN KEY (campain_id_id) REFERENCES campaigns (id)');
        $this->addSql('ALTER TABLE fund ADD CONSTRAINT FK_DC923E109D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE campaigns DROP FOREIGN KEY FK_E37374708FDDAB70');
        $this->addSql('ALTER TABLE fund DROP FOREIGN KEY FK_DC923E1079384475');
        $this->addSql('ALTER TABLE fund DROP FOREIGN KEY FK_DC923E109D86650F');
        $this->addSql('DROP TABLE campaigns');
        $this->addSql('DROP TABLE fund');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
