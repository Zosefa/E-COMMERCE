<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240416175008 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP CONSTRAINT fk_c7440455a6e44244');
        $this->addSql('ALTER TABLE vendeur DROP CONSTRAINT fk_7af49996a6e44244');
        $this->addSql('DROP SEQUENCE facture_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE pays_id_seq CASCADE');
        $this->addSql('ALTER TABLE facture DROP CONSTRAINT fk_fe8664108bf5c2e6');
        $this->addSql('ALTER TABLE facture DROP CONSTRAINT fk_fe866410858c065e');
        $this->addSql('ALTER TABLE commande_produit DROP CONSTRAINT fk_df1e9e8782ea2e54');
        $this->addSql('ALTER TABLE commande_produit DROP CONSTRAINT fk_df1e9e87f347efb');
        $this->addSql('DROP TABLE pays');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE commande_produit');
        $this->addSql('DROP INDEX idx_c7440455a6e44244');
        $this->addSql('ALTER TABLE client DROP pays_id');
        $this->addSql('ALTER TABLE commande ADD produit_id INT NOT NULL');
        $this->addSql('ALTER TABLE commande ADD mode_p_id INT NOT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D2D52D2F1 FOREIGN KEY (mode_p_id) REFERENCES mode_paiement (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_6EEAA67DF347EFB ON commande (produit_id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D2D52D2F1 ON commande (mode_p_id)');
        $this->addSql('ALTER TABLE produit ADD qte_dispo INT DEFAULT NULL');
        $this->addSql('DROP INDEX idx_7af49996a6e44244');
        $this->addSql('ALTER TABLE vendeur DROP pays_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE facture_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE pays_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE pays (id INT NOT NULL, pays VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE facture (id INT NOT NULL, commandes_id INT NOT NULL, vendeur_id INT NOT NULL, qte INT NOT NULL, date_livraison DATE NOT NULL, date_facture DATE NOT NULL, remise DOUBLE PRECISION NOT NULL, montant_total DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_fe866410858c065e ON facture (vendeur_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_fe8664108bf5c2e6 ON facture (commandes_id)');
        $this->addSql('CREATE TABLE commande_produit (commande_id INT NOT NULL, produit_id INT NOT NULL, PRIMARY KEY(commande_id, produit_id))');
        $this->addSql('CREATE INDEX idx_df1e9e87f347efb ON commande_produit (produit_id)');
        $this->addSql('CREATE INDEX idx_df1e9e8782ea2e54 ON commande_produit (commande_id)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT fk_fe8664108bf5c2e6 FOREIGN KEY (commandes_id) REFERENCES commande (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT fk_fe866410858c065e FOREIGN KEY (vendeur_id) REFERENCES vendeur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE commande_produit ADD CONSTRAINT fk_df1e9e8782ea2e54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE commande_produit ADD CONSTRAINT fk_df1e9e87f347efb FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE commande DROP CONSTRAINT FK_6EEAA67DF347EFB');
        $this->addSql('ALTER TABLE commande DROP CONSTRAINT FK_6EEAA67D2D52D2F1');
        $this->addSql('DROP INDEX IDX_6EEAA67DF347EFB');
        $this->addSql('DROP INDEX IDX_6EEAA67D2D52D2F1');
        $this->addSql('ALTER TABLE commande DROP produit_id');
        $this->addSql('ALTER TABLE commande DROP mode_p_id');
        $this->addSql('ALTER TABLE client ADD pays_id INT NOT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT fk_c7440455a6e44244 FOREIGN KEY (pays_id) REFERENCES pays (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_c7440455a6e44244 ON client (pays_id)');
        $this->addSql('ALTER TABLE vendeur ADD pays_id INT NOT NULL');
        $this->addSql('ALTER TABLE vendeur ADD CONSTRAINT fk_7af49996a6e44244 FOREIGN KEY (pays_id) REFERENCES pays (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_7af49996a6e44244 ON vendeur (pays_id)');
        $this->addSql('ALTER TABLE produit DROP qte_dispo');
    }
}
