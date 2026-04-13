<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration TP3 — Création des tables : filiere, etablissement, evenement, filiere_etablissement
 *
 * Relations :
 *   - filiere    <--> etablissement  : ManyToMany (N:N) → table pivot filiere_etablissement
 *   - filiere    --> evenement        : OneToMany  (1:N) → clé étrangère filiere_id dans evenement
 *   - etablissement --> evenement     : OneToMany  (1:N) → clé étrangère etablissement_id dans evenement
 */
final class Version20260413000001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création des tables filiere, etablissement, evenement et filiere_etablissement';
    }

    public function up(Schema $schema): void
    {
        // Table filiere
        $this->addSql('CREATE TABLE filiere (
            id          INT AUTO_INCREMENT NOT NULL,
            nom         VARCHAR(150) NOT NULL,
            niveau      VARCHAR(50)  NOT NULL,
            description LONGTEXT     DEFAULT NULL,
            duree       VARCHAR(100) DEFAULT NULL,
            debouches   LONGTEXT     DEFAULT NULL,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Table etablissement
        $this->addSql('CREATE TABLE etablissement (
            id          INT AUTO_INCREMENT NOT NULL,
            nom         VARCHAR(200) NOT NULL,
            sigle       VARCHAR(30)  DEFAULT NULL,
            ville       VARCHAR(100) NOT NULL,
            type        VARCHAR(100) DEFAULT NULL,
            description LONGTEXT     DEFAULT NULL,
            email       VARCHAR(150) DEFAULT NULL,
            telephone   VARCHAR(30)  DEFAULT NULL,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Table pivot ManyToMany filiere <--> etablissement
        $this->addSql('CREATE TABLE filiere_etablissement (
            filiere_id      INT NOT NULL,
            etablissement_id INT NOT NULL,
            PRIMARY KEY(filiere_id, etablissement_id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Table evenement
        $this->addSql('CREATE TABLE evenement (
            id               INT AUTO_INCREMENT NOT NULL,
            filiere_id       INT  DEFAULT NULL,
            etablissement_id INT  DEFAULT NULL,
            titre            VARCHAR(200) NOT NULL,
            description      LONGTEXT     DEFAULT NULL,
            date_evenement   DATETIME     NOT NULL,
            lieu             VARCHAR(150) DEFAULT NULL,
            type             VARCHAR(50)  DEFAULT NULL,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Clés étrangères table pivot
        $this->addSql('ALTER TABLE filiere_etablissement
            ADD CONSTRAINT FK_FILIERE_ETAB_FIL  FOREIGN KEY (filiere_id)      REFERENCES filiere(id)       ON DELETE CASCADE,
            ADD CONSTRAINT FK_FILIERE_ETAB_ETAB FOREIGN KEY (etablissement_id) REFERENCES etablissement(id) ON DELETE CASCADE');

        // Index sur la table pivot
        $this->addSql('CREATE INDEX IDX_FILIERE_ETAB_ETAB ON filiere_etablissement (etablissement_id)');

        // Clés étrangères evenement
        $this->addSql('ALTER TABLE evenement
            ADD CONSTRAINT FK_EVT_FILIERE       FOREIGN KEY (filiere_id)       REFERENCES filiere(id)       ON DELETE SET NULL,
            ADD CONSTRAINT FK_EVT_ETABLISSEMENT FOREIGN KEY (etablissement_id) REFERENCES etablissement(id) ON DELETE SET NULL');

        $this->addSql('CREATE INDEX IDX_EVT_FILIERE       ON evenement (filiere_id)');
        $this->addSql('CREATE INDEX IDX_EVT_ETABLISSEMENT ON evenement (etablissement_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE filiere_etablissement DROP FOREIGN KEY FK_FILIERE_ETAB_FIL');
        $this->addSql('ALTER TABLE filiere_etablissement DROP FOREIGN KEY FK_FILIERE_ETAB_ETAB');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_EVT_FILIERE');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_EVT_ETABLISSEMENT');
        $this->addSql('DROP TABLE filiere_etablissement');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE filiere');
        $this->addSql('DROP TABLE etablissement');
    }
}
