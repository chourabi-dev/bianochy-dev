<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250204134132 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE checkout_related_product (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, request_id INT DEFAULT NULL, quantity INT NOT NULL, INDEX IDX_475484724584665A (product_id), INDEX IDX_47548472427EB8A5 (request_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE checkout_related_product_pack (id INT AUTO_INCREMENT NOT NULL, pack_id INT DEFAULT NULL, request_id INT DEFAULT NULL, quantity INT NOT NULL, INDEX IDX_FF5FE3551919B217 (pack_id), INDEX IDX_FF5FE355427EB8A5 (request_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE checkout_related_product ADD CONSTRAINT FK_475484724584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE checkout_related_product ADD CONSTRAINT FK_47548472427EB8A5 FOREIGN KEY (request_id) REFERENCES checkout_request (id)');
        $this->addSql('ALTER TABLE checkout_related_product_pack ADD CONSTRAINT FK_FF5FE3551919B217 FOREIGN KEY (pack_id) REFERENCES products_pack (id)');
        $this->addSql('ALTER TABLE checkout_related_product_pack ADD CONSTRAINT FK_FF5FE355427EB8A5 FOREIGN KEY (request_id) REFERENCES checkout_request (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE checkout_related_product DROP FOREIGN KEY FK_475484724584665A');
        $this->addSql('ALTER TABLE checkout_related_product DROP FOREIGN KEY FK_47548472427EB8A5');
        $this->addSql('ALTER TABLE checkout_related_product_pack DROP FOREIGN KEY FK_FF5FE3551919B217');
        $this->addSql('ALTER TABLE checkout_related_product_pack DROP FOREIGN KEY FK_FF5FE355427EB8A5');
        $this->addSql('DROP TABLE checkout_related_product');
        $this->addSql('DROP TABLE checkout_related_product_pack');
    }
}
