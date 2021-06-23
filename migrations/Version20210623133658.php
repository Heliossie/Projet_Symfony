<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210623133658 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carpark ADD client_id INT NOT NULL');
        $this->addSql('ALTER TABLE carpark ADD CONSTRAINT FK_82CB447919EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_82CB447919EB6921 ON carpark (client_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carpark DROP FOREIGN KEY FK_82CB447919EB6921');
        $this->addSql('DROP INDEX IDX_82CB447919EB6921 ON carpark');
        $this->addSql('ALTER TABLE carpark DROP client_id');
    }
}
