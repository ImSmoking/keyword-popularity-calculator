<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230617164646 extends AbstractMigration
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
                CHANGE `rocks_count` `hits_rocks` int NOT NULL DEFAULT '0' COMMENT 'Total number of times the keyword has appeared in a positive context' AFTER `source`,
                CHANGE `sucks_count` `hits_sucks` int NOT NULL DEFAULT '0' COMMENT 'Total number of times the keyword has appeared in a negative context' AFTER `hits_rocks`,
                CHANGE `total_count` `hits_total` int NOT NULL DEFAULT '0' COMMENT 'Total number of times the keyword has appeared in both positive and negative context (check parameter)' AFTER `hits_sucks`;        
        ");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql("
              ALTER TABLE `keyword`
                CHANGE `hits_rocks` `rocks_count` int NOT NULL DEFAULT '0' AFTER `source`,
                CHANGE `hits_sucks` `sucks_count` int NOT NULL DEFAULT '0' AFTER `rocks_count`,
                CHANGE `hits_total` `total_count` int NOT NULL DEFAULT '0' AFTER `sucks_count`;        
        ");
    }
}
