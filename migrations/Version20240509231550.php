<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240509231550 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fund ADD user_id_id INT NOT NULL, CHANGE campain_id campain_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE fund ADD CONSTRAINT FK_DC923E1079384475 FOREIGN KEY (campain_id_id) REFERENCES campaigns (id)');
        $this->addSql('ALTER TABLE fund ADD CONSTRAINT FK_DC923E109D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_DC923E1079384475 ON fund (campain_id_id)');
        $this->addSql('CREATE INDEX IDX_DC923E109D86650F ON fund (user_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fund DROP FOREIGN KEY FK_DC923E1079384475');
        $this->addSql('ALTER TABLE fund DROP FOREIGN KEY FK_DC923E109D86650F');
        $this->addSql('DROP INDEX IDX_DC923E1079384475 ON fund');
        $this->addSql('DROP INDEX IDX_DC923E109D86650F ON fund');
        $this->addSql('ALTER TABLE fund ADD campain_id INT NOT NULL, DROP campain_id_id, DROP user_id_id');
    }
}
