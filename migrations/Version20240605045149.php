<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240605045149 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie ADD slug VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD slug VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD slug VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE facture ADD slug VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE mode_paiement ADD slug VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD slug VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE quartier ADD slug VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD slug VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE vendeur ADD slug VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE ville ADD slug VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE mode_paiement DROP slug');
        $this->addSql('ALTER TABLE quartier DROP slug');
        $this->addSql('ALTER TABLE ville DROP slug');
        $this->addSql('ALTER TABLE client DROP slug');
        $this->addSql('ALTER TABLE facture DROP slug');
        $this->addSql('ALTER TABLE vendeur DROP slug');
        $this->addSql('ALTER TABLE "user" DROP slug');
        $this->addSql('ALTER TABLE categorie DROP slug');
        $this->addSql('ALTER TABLE produit DROP slug');
        $this->addSql('ALTER TABLE commande DROP slug');
    }
}
