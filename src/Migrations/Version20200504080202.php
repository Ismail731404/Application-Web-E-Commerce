<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200504080202 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom_categorie VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_497DD634DD8CA775 (nom_categorie), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dechet (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, categorie_id_id INT NOT NULL, filename VARCHAR(255) NOT NULL, designation VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, quantite_stock INT NOT NULL, created_at DATETIME NOT NULL, ville VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, code_postal VARCHAR(255) NOT NULL, origine INT NOT NULL, nature INT NOT NULL, prix NUMERIC(10, 4) NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_53C0FC608947610D (designation), INDEX IDX_53C0FC60BCF5E72D (categorie_id), INDEX IDX_53C0FC608A3C7387 (categorie_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dechet ADD CONSTRAINT FK_53C0FC60BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE dechet DROP FOREIGN KEY FK_53C0FC60BCF5E72D');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE dechet');
    }
}
