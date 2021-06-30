<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210630122615 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE pricelist_parking');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pricelist_parking (pricelist_id INT NOT NULL, parking_id INT NOT NULL, INDEX IDX_371C719FF17B2DD (parking_id), INDEX IDX_371C719F89045958 (pricelist_id), PRIMARY KEY(pricelist_id, parking_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE pricelist_parking ADD CONSTRAINT FK_371C719F89045958 FOREIGN KEY (pricelist_id) REFERENCES pricelist (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pricelist_parking ADD CONSTRAINT FK_371C719FF17B2DD FOREIGN KEY (parking_id) REFERENCES parking (id) ON DELETE CASCADE');
    }
}
