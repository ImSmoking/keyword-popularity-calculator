<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230622140833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX keyword__name_source ON keyword');
        $this->addSql('ALTER TABLE keyword CHANGE `name` `term` VARCHAR(45) NOT NULL AFTER `id`');
        $this->addSql('CREATE UNIQUE INDEX keyword__term_source ON keyword (term, source)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX keyword__term_source ON keyword');
        $this->addSql('ALTER TABLE keyword CHANGE `term` `name` VARCHAR(45) NOT NULL AFTER `id`');
        $this->addSql('CREATE UNIQUE INDEX keyword__name_source ON keyword (name, source)');
    }
}
