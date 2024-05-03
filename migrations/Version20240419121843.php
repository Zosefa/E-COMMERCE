<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240419121843 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE commentaire_id_seq CASCADE');
        $this->addSql('ALTER TABLE commentaire DROP CONSTRAINT fk_67f068bc19eb6921');
        $this->addSql('ALTER TABLE commentaire DROP CONSTRAINT fk_67f068bcf347efb');
        $this->addSql('DROP TABLE commentaire');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE commentaire_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE commentaire (id INT NOT NULL, client_id INT NOT NULL, produit_id INT NOT NULL, commentaire TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_67f068bcf347efb ON commentaire (produit_id)');
        $this->addSql('CREATE INDEX idx_67f068bc19eb6921 ON commentaire (client_id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT fk_67f068bc19eb6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT fk_67f068bcf347efb FOREIGN KEY (produit_id) REFERENCES produit (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
