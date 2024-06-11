<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240503192535 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE quartier_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ville_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE quartier (id INT NOT NULL, ville_id INT NOT NULL, quartier VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FEE8962DA73F0036 ON quartier (ville_id)');
        $this->addSql('CREATE TABLE ville (id INT NOT NULL, ville VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE quartier ADD CONSTRAINT FK_FEE8962DA73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE client ADD quartier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455DF1E57AB FOREIGN KEY (quartier_id) REFERENCES quartier (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_C7440455DF1E57AB ON client (quartier_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE client DROP CONSTRAINT FK_C7440455DF1E57AB');
        $this->addSql('DROP SEQUENCE quartier_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ville_id_seq CASCADE');
        $this->addSql('ALTER TABLE quartier DROP CONSTRAINT FK_FEE8962DA73F0036');
        $this->addSql('DROP TABLE quartier');
        $this->addSql('DROP TABLE ville');
        $this->addSql('DROP INDEX IDX_C7440455DF1E57AB');
        $this->addSql('ALTER TABLE client DROP quartier_id');
    }
}
