<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240510012212 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fund (id INT AUTO_INCREMENT NOT NULL, campain_id_id INT NOT NULL, user_id_id INT NOT NULL, user_email VARCHAR(255) NOT NULL, user_password VARCHAR(50) NOT NULL, amount INT NOT NULL, date DATE DEFAULT NULL, INDEX IDX_DC923E1079384475 (campain_id_id), INDEX IDX_DC923E109D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fund ADD CONSTRAINT FK_DC923E1079384475 FOREIGN KEY (campain_id_id) REFERENCES campaigns (id)');
        $this->addSql('ALTER TABLE fund ADD CONSTRAINT FK_DC923E109D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fund DROP FOREIGN KEY FK_DC923E1079384475');
        $this->addSql('ALTER TABLE fund DROP FOREIGN KEY FK_DC923E109D86650F');
        $this->addSql('DROP TABLE fund');
    }
}
