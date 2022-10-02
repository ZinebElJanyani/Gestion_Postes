<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220803203204 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE affectation (id INT AUTO_INCREMENT NOT NULL, employe_id INT NOT NULL, poste_id INT NOT NULL, date_affectation DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', UNIQUE INDEX UNIQ_F4DD61D31B65292 (employe_id), UNIQUE INDEX UNIQ_F4DD61D3A0905086 (poste_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee_users_postes (id INT AUTO_INCREMENT NOT NULL, employe_id INT NOT NULL, poste_id INT NOT NULL, date_affectation DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', UNIQUE INDEX UNIQ_7BA499B41B65292 (employe_id), UNIQUE INDEX UNIQ_7BA499B4A0905086 (poste_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE affectation ADD CONSTRAINT FK_F4DD61D31B65292 FOREIGN KEY (employe_id) REFERENCES employee_users (id)');
        $this->addSql('ALTER TABLE affectation ADD CONSTRAINT FK_F4DD61D3A0905086 FOREIGN KEY (poste_id) REFERENCES postes (id)');
        $this->addSql('ALTER TABLE employee_users_postes ADD CONSTRAINT FK_7BA499B41B65292 FOREIGN KEY (employe_id) REFERENCES employee_users (id)');
        $this->addSql('ALTER TABLE employee_users_postes ADD CONSTRAINT FK_7BA499B4A0905086 FOREIGN KEY (poste_id) REFERENCES postes (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE affectation');
        $this->addSql('DROP TABLE employee_users_postes');
    }
}
