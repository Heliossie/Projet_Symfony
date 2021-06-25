<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210625133841 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parking DROP FOREIGN KEY FK_B237527A89045958');
        $this->addSql('DROP INDEX IDX_B237527A89045958 ON parking');
        $this->addSql('ALTER TABLE parking DROP pricelist_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parking ADD pricelist_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parking ADD CONSTRAINT FK_B237527A89045958 FOREIGN KEY (pricelist_id) REFERENCES pricelist (id)');
        $this->addSql('CREATE INDEX IDX_B237527A89045958 ON parking (pricelist_id)');
    }
}
