<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200508160857 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

      
        $this->addSql('ALTER TABLE dechet CHANGE filename filename VARCHAR(255) , CHANGE quantite_stock quantite_stock INT NOT NULL, CHANGE prix prix NUMERIC(10, 0) NOT NULL, CHANGE updated_at updated_at DATETIME  NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE publicite');
        $this->addSql('ALTER TABLE dechet CHANGE filename filename VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE quantite_stock quantite_stock INT DEFAULT NULL, CHANGE prix prix NUMERIC(11, 0) NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
    }
}
