<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250207164052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('');
        $this->addSql('');
        $this->addSql('ALTER TABLE promotion_category ADD CONSTRAINT FK_C018BD85139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promotion_category ADD CONSTRAINT FK_C018BD8512469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promotion_sub_category ADD CONSTRAINT FK_DA34329B139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promotion_sub_category ADD CONSTRAINT FK_DA34329BF7BFE87C FOREIGN KEY (sub_category_id) REFERENCES sub_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sub_category DROP FOREIGN KEY FK_BCE3F798139DF194');
        $this->addSql('DROP INDEX IDX_BCE3F798139DF194 ON sub_category');
        $this->addSql('ALTER TABLE sub_category DROP promotion_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE promotion_category DROP FOREIGN KEY FK_C018BD85139DF194');
        $this->addSql('ALTER TABLE promotion_category DROP FOREIGN KEY FK_C018BD8512469DE2');
        $this->addSql('ALTER TABLE promotion_sub_category DROP FOREIGN KEY FK_DA34329B139DF194');
        $this->addSql('ALTER TABLE promotion_sub_category DROP FOREIGN KEY FK_DA34329BF7BFE87C');
        $this->addSql('DROP TABLE promotion_category');
        $this->addSql('DROP TABLE promotion_sub_category');
        $this->addSql('ALTER TABLE sub_category ADD promotion_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sub_category ADD CONSTRAINT FK_BCE3F798139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id)');
        $this->addSql('CREATE INDEX IDX_BCE3F798139DF194 ON sub_category (promotion_id)');
    }
}
