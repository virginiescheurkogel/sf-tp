<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210325161652 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clients ADD address_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE clients ADD CONSTRAINT FK_C82E74F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('CREATE INDEX IDX_C82E74F5B7AF75 ON clients (address_id)');
        $this->addSql('ALTER TABLE invoices ADD client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE invoices ADD CONSTRAINT FK_6A2F2F9519EB6921 FOREIGN KEY (client_id) REFERENCES clients (id)');
        $this->addSql('CREATE INDEX IDX_6A2F2F9519EB6921 ON invoices (client_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clients DROP FOREIGN KEY FK_C82E74F5B7AF75');
        $this->addSql('DROP INDEX IDX_C82E74F5B7AF75 ON clients');
        $this->addSql('ALTER TABLE clients DROP address_id');
        $this->addSql('ALTER TABLE invoices DROP FOREIGN KEY FK_6A2F2F9519EB6921');
        $this->addSql('DROP INDEX IDX_6A2F2F9519EB6921 ON invoices');
        $this->addSql('ALTER TABLE invoices DROP client_id');
    }
}
