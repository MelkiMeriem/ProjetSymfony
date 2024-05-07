<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240507094721 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE campaigns ADD CONSTRAINT FK_E37374708FDDAB70 FOREIGN KEY (owner_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD roles JSON NOT NULL COMMENT \'(DC2Type:json)\', DROP number, CHANGE email email VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE campaigns DROP FOREIGN KEY FK_E37374708FDDAB70');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
        $this->addSql('ALTER TABLE user ADD number VARCHAR(255) NOT NULL, DROP roles, CHANGE email email VARCHAR(255) NOT NULL');
    }
}
