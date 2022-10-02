<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220730213048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE plateaux (id INT AUTO_INCREMENT NOT NULL, departement_id INT NOT NULL, INDEX IDX_3E52003CCF9E01E (departement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE postes (id INT AUTO_INCREMENT NOT NULL, plateau_id INT DEFAULT NULL, INDEX IDX_5A763C64927847DB (plateau_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE plateaux ADD CONSTRAINT FK_3E52003CCF9E01E FOREIGN KEY (departement_id) REFERENCES departements (id)');
        $this->addSql('ALTER TABLE postes ADD CONSTRAINT FK_5A763C64927847DB FOREIGN KEY (plateau_id) REFERENCES plateaux (id)');
        $this->addSql('ALTER TABLE employee_users DROP departement');
        $this->addSql('ALTER TABLE rcusers DROP FOREIGN KEY FK_BA5A317C322B8E0F');
        $this->addSql('DROP INDEX UNIQ_BA5A317C322B8E0F ON rcusers');
        $this->addSql('ALTER TABLE rcusers CHANGE n_departement_id departement_id INT NOT NULL');
        $this->addSql('ALTER TABLE rcusers ADD CONSTRAINT FK_BA5A317CCCF9E01E FOREIGN KEY (departement_id) REFERENCES departements (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BA5A317CCCF9E01E ON rcusers (departement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE postes DROP FOREIGN KEY FK_5A763C64927847DB');
        $this->addSql('DROP TABLE plateaux');
        $this->addSql('DROP TABLE postes');
        $this->addSql('ALTER TABLE employee_users ADD departement VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE rcusers DROP FOREIGN KEY FK_BA5A317CCCF9E01E');
        $this->addSql('DROP INDEX UNIQ_BA5A317CCCF9E01E ON rcusers');
        $this->addSql('ALTER TABLE rcusers CHANGE departement_id n_departement_id INT NOT NULL');
        $this->addSql('ALTER TABLE rcusers ADD CONSTRAINT FK_BA5A317C322B8E0F FOREIGN KEY (n_departement_id) REFERENCES departements (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BA5A317C322B8E0F ON rcusers (n_departement_id)');
    }
}
