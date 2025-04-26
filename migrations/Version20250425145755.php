<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250425145755 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conges ADD CONSTRAINT FK_6327DE3A864AABAC FOREIGN KEY (ref_pilote_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE conges ADD CONSTRAINT FK_6327DE3AF50CD755 FOREIGN KEY (ref_validation_admin_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955B61ED040 FOREIGN KEY (ref_utilisateur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE vol ADD CONSTRAINT FK_95C97EB864AABAC FOREIGN KEY (ref_pilote_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conges DROP FOREIGN KEY FK_6327DE3A864AABAC');
        $this->addSql('ALTER TABLE conges DROP FOREIGN KEY FK_6327DE3AF50CD755');
        $this->addSql('ALTER TABLE vol DROP FOREIGN KEY FK_95C97EB864AABAC');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955B61ED040');
    }
}
