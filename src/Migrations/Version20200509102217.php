<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200509102217 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_C7440455E7927C74 ON client');
        $this->addSql('ALTER TABLE client DROP email, DROP roles, DROP password, DROP fisrt_name, DROP last_name, DROP phone, DROP created_at, DROP update_at, DROP activation_token, DROP reset_token, DROP indicateur, DROP last_login, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD discr VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX UNIQ_DE4CF066E7927C74 ON employer');
        $this->addSql('ALTER TABLE employer DROP email, DROP roles, DROP password, DROP fisrt_name, DROP last_name, DROP phone, DROP created_at, DROP update_at, DROP activation_token, DROP reset_token, DROP indicateur, DROP last_login, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE employer ADD CONSTRAINT FK_DE4CF066BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455BF396750');
        $this->addSql('ALTER TABLE client ADD email VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD roles JSON NOT NULL, ADD password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD fisrt_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD last_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD phone VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD created_at DATETIME NOT NULL, ADD update_at DATETIME NOT NULL, ADD activation_token VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD reset_token VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD indicateur VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD last_login DATETIME DEFAULT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455E7927C74 ON client (email)');
        $this->addSql('ALTER TABLE employer DROP FOREIGN KEY FK_DE4CF066BF396750');
        $this->addSql('ALTER TABLE employer ADD email VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD roles JSON NOT NULL, ADD password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD fisrt_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD last_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD phone VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD created_at DATETIME NOT NULL, ADD update_at DATETIME NOT NULL, ADD activation_token VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD reset_token VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD indicateur VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD last_login DATETIME DEFAULT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DE4CF066E7927C74 ON employer (email)');
        $this->addSql('ALTER TABLE user DROP discr');
    }
}
