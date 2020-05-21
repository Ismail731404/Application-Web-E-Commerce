<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200509091535 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE adresse (id INT AUTO_INCREMENT NOT NULL, pays VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, region VARCHAR(255) NOT NULL, code_postal INT NOT NULL, boite_postal VARCHAR(255) NOT NULL, rue VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, update_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, adresse_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, fisrt_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, update_at DATETIME NOT NULL, activation_token VARCHAR(255) DEFAULT NULL, reset_token VARCHAR(255) DEFAULT NULL, indicateur VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, filename VARCHAR(255) NOT NULL, terms TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_C7440455E7927C74 (email), INDEX IDX_C74404554DE7DC5C (adresse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, fisrt_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, update_at DATETIME NOT NULL, activation_token VARCHAR(255) DEFAULT NULL, reset_token VARCHAR(255) DEFAULT NULL, indicateur VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employer (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, fisrt_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, update_at DATETIME NOT NULL, activation_token VARCHAR(255) DEFAULT NULL, reset_token VARCHAR(255) DEFAULT NULL, indicateur VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, departement VARCHAR(255) NOT NULL, bureau VARCHAR(255) NOT NULL, numero_bureau VARCHAR(255) NOT NULL, fonction VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_DE4CF066E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C74404554DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        
        $this->addSql('ALTER TABLE publicite CHANGE description description TINYTEXT DEFAULT NULL, CHANGE url url VARCHAR(255) DEFAULT NULL, CHANGE nompublicite nompublicite VARCHAR(20) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C74404554DE7DC5C');
        $this->addSql('DROP TABLE adresse');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE employer');
       
        $this->addSql('ALTER TABLE publicite CHANGE description description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE url url TINYTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nompublicite nompublicite VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
