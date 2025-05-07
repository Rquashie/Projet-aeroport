<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250430071321 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conges DROP FOREIGN KEY FK_6327DE3A864AABAC');
        $this->addSql('ALTER TABLE conges DROP FOREIGN KEY FK_6327DE3AF50CD755');
        $this->addSql('ALTER TABLE vol DROP FOREIGN KEY FK_95C97EB864AABAC');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955B61ED040');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, ref_modele_id INT NOT NULL, email VARCHAR(180) NOT NULL, nom VARCHAR(180) NOT NULL, prenom VARCHAR(180) NOT NULL, ville VARCHAR(180) NOT NULL, date_naissance DATE NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, INDEX IDX_8D93D649DF4EB64F (ref_modele_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649DF4EB64F FOREIGN KEY (ref_modele_id) REFERENCES modele (id)');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3DF4EB64F');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('ALTER TABLE conges DROP FOREIGN KEY FK_6327DE3A864AABAC');
        $this->addSql('ALTER TABLE conges DROP FOREIGN KEY FK_6327DE3AF50CD755');
        $this->addSql('ALTER TABLE conges ADD CONSTRAINT FK_6327DE3A864AABAC FOREIGN KEY (ref_pilote_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE conges ADD CONSTRAINT FK_6327DE3AF50CD755 FOREIGN KEY (ref_validation_admin_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955B61ED040');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955B61ED040 FOREIGN KEY (ref_utilisateur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE vol DROP FOREIGN KEY FK_95C97EB864AABAC');
        $this->addSql('ALTER TABLE vol ADD CONSTRAINT FK_95C97EB864AABAC FOREIGN KEY (ref_pilote_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conges DROP FOREIGN KEY FK_6327DE3A864AABAC');
        $this->addSql('ALTER TABLE conges DROP FOREIGN KEY FK_6327DE3AF50CD755');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955B61ED040');
        $this->addSql('ALTER TABLE vol DROP FOREIGN KEY FK_95C97EB864AABAC');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, ref_modele_id INT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prenom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, mot_de_passe VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date_naissance VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ville VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, role VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_1D1C63B3DF4EB64F (ref_modele_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3DF4EB64F FOREIGN KEY (ref_modele_id) REFERENCES modele (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649DF4EB64F');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE conges DROP FOREIGN KEY FK_6327DE3A864AABAC');
        $this->addSql('ALTER TABLE conges DROP FOREIGN KEY FK_6327DE3AF50CD755');
        $this->addSql('ALTER TABLE conges ADD CONSTRAINT FK_6327DE3A864AABAC FOREIGN KEY (ref_pilote_id) REFERENCES utilisateur (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE conges ADD CONSTRAINT FK_6327DE3AF50CD755 FOREIGN KEY (ref_validation_admin_id) REFERENCES utilisateur (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE vol DROP FOREIGN KEY FK_95C97EB864AABAC');
        $this->addSql('ALTER TABLE vol ADD CONSTRAINT FK_95C97EB864AABAC FOREIGN KEY (ref_pilote_id) REFERENCES utilisateur (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955B61ED040');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955B61ED040 FOREIGN KEY (ref_utilisateur_id) REFERENCES utilisateur (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
