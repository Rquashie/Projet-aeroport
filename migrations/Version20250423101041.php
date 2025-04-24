<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250423101041 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE avion (id INT AUTO_INCREMENT NOT NULL, ref_modele_id INT NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_234D9D38DF4EB64F (ref_modele_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conges (id INT AUTO_INCREMENT NOT NULL, ref_pilote_id INT DEFAULT NULL, ref_validation_admin_id INT NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, est_valide TINYINT(1) NOT NULL, INDEX IDX_6327DE3A864AABAC (ref_pilote_id), INDEX IDX_6327DE3AF50CD755 (ref_validation_admin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, ref_utilisateur_id INT DEFAULT NULL, ref_vol_id INT DEFAULT NULL, prix_billet DOUBLE PRECISION NOT NULL, INDEX IDX_42C84955B61ED040 (ref_utilisateur_id), INDEX IDX_42C84955EA329383 (ref_vol_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, ref_modele_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, mot_de_passe VARCHAR(255) NOT NULL, date_naissance VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, INDEX IDX_1D1C63B3DF4EB64F (ref_modele_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vol (id INT AUTO_INCREMENT NOT NULL, ref_pilote_id INT NOT NULL, ref_avion_id INT DEFAULT NULL, ville_depart VARCHAR(255) NOT NULL, ville_arrive VARCHAR(255) NOT NULL, date_depart DATE NOT NULL, heure_depart TIME NOT NULL, prix_billet_initiale DOUBLE PRECISION NOT NULL, INDEX IDX_95C97EB864AABAC (ref_pilote_id), INDEX IDX_95C97EB6AC7EC6 (ref_avion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE avion ADD CONSTRAINT FK_234D9D38DF4EB64F FOREIGN KEY (ref_modele_id) REFERENCES modele (id)');
        $this->addSql('ALTER TABLE conges ADD CONSTRAINT FK_6327DE3A864AABAC FOREIGN KEY (ref_pilote_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE conges ADD CONSTRAINT FK_6327DE3AF50CD755 FOREIGN KEY (ref_validation_admin_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955B61ED040 FOREIGN KEY (ref_utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955EA329383 FOREIGN KEY (ref_vol_id) REFERENCES vol (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3DF4EB64F FOREIGN KEY (ref_modele_id) REFERENCES modele (id)');
        $this->addSql('ALTER TABLE vol ADD CONSTRAINT FK_95C97EB864AABAC FOREIGN KEY (ref_pilote_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE vol ADD CONSTRAINT FK_95C97EB6AC7EC6 FOREIGN KEY (ref_avion_id) REFERENCES avion (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avion DROP FOREIGN KEY FK_234D9D38DF4EB64F');
        $this->addSql('ALTER TABLE conges DROP FOREIGN KEY FK_6327DE3A864AABAC');
        $this->addSql('ALTER TABLE conges DROP FOREIGN KEY FK_6327DE3AF50CD755');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955B61ED040');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955EA329383');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3DF4EB64F');
        $this->addSql('ALTER TABLE vol DROP FOREIGN KEY FK_95C97EB864AABAC');
        $this->addSql('ALTER TABLE vol DROP FOREIGN KEY FK_95C97EB6AC7EC6');
        $this->addSql('DROP TABLE avion');
        $this->addSql('DROP TABLE conges');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE vol');
    }
}
