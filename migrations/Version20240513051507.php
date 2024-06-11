<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240513051507 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE facture_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE facture (id INT NOT NULL, numero_facture VARCHAR(255) NOT NULL, date_facture DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE commande ADD facture_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D7F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_6EEAA67D7F2DEE08 ON commande (facture_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE commande DROP CONSTRAINT FK_6EEAA67D7F2DEE08');
        $this->addSql('DROP SEQUENCE facture_id_seq CASCADE');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP INDEX IDX_6EEAA67D7F2DEE08');
        $this->addSql('ALTER TABLE commande DROP facture_id');
    }
}
