<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250205083745 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE payment_status (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE checkout_request ADD payment_status_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE checkout_request ADD CONSTRAINT FK_C7FC6BE628DE2F95 FOREIGN KEY (payment_status_id) REFERENCES payment_status (id)');
        $this->addSql('CREATE INDEX IDX_C7FC6BE628DE2F95 ON checkout_request (payment_status_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE checkout_request DROP FOREIGN KEY FK_C7FC6BE628DE2F95');
        $this->addSql('DROP TABLE payment_status');
        $this->addSql('DROP INDEX IDX_C7FC6BE628DE2F95 ON checkout_request');
        $this->addSql('ALTER TABLE checkout_request DROP payment_status_id');
    }
}
