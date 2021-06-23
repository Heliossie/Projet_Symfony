<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210623141454 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carpark ADD invoice_id INT NOT NULL');
        $this->addSql('ALTER TABLE carpark ADD CONSTRAINT FK_82CB44792989F1FD FOREIGN KEY (invoice_id) REFERENCES invoice (id)');
        $this->addSql('CREATE INDEX IDX_82CB44792989F1FD ON carpark (invoice_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carpark DROP FOREIGN KEY FK_82CB44792989F1FD');
        $this->addSql('DROP INDEX IDX_82CB44792989F1FD ON carpark');
        $this->addSql('ALTER TABLE carpark DROP invoice_id');
    }
}
