<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250204123419 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE perfum (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, photo VARCHAR(1000) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product ADD perfum_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD4A8508A2 FOREIGN KEY (perfum_id) REFERENCES perfum (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD4A8508A2 ON product (perfum_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD4A8508A2');
        $this->addSql('DROP TABLE perfum');
        $this->addSql('DROP INDEX IDX_D34A04AD4A8508A2 ON product');
        $this->addSql('ALTER TABLE product DROP perfum_id');
    }
}
