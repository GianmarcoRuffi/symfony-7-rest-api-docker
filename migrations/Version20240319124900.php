<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240319124900 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bike CHANGE engine_serial engine_serial VARCHAR(255) DEFAULT NULL');
        $this->addSql('DROP INDEX `primary` ON engine');
        $this->addSql('ALTER TABLE engine DROP id');
        $this->addSql('ALTER TABLE engine ADD PRIMARY KEY (serial_code)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bike CHANGE engine_serial engine_serial VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON engine');
        $this->addSql('ALTER TABLE engine ADD id INT NOT NULL');
        $this->addSql('ALTER TABLE engine ADD PRIMARY KEY (id)');
    }
}
