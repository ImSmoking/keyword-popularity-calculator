<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230622164006 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("
              ALTER TABLE `keyword`
                CHANGE `hits_rocks` `hits_positive` int NOT NULL DEFAULT '0' AFTER `source`,
                CHANGE `hits_sucks` `hits_negative` int NOT NULL DEFAULT '0' AFTER `hits_positive`
        ");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql("
              ALTER TABLE `keyword`
                CHANGE `hits_positive` `hits_rocks` int NOT NULL DEFAULT '0' AFTER `source`,
                CHANGE `hits_negative` `hits_sucks` int NOT NULL DEFAULT '0' AFTER `hits_positive`
        ");
    }
}
