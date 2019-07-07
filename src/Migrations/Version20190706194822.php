<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190706194822 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE task ADD public TINYINT(1) NULL');
        $this->addSql('UPDATE task SET `public` = 1;');
        $this->addSql('ALTER TABLE task MODIFY `public` TINYINT(1) NOT NULL');

        $this->addSql('ALTER TABLE category ADD `public` TINYINT(1) NULL');
        $this->addSql('UPDATE category SET `public` = 1;');
        $this->addSql('ALTER TABLE category MODIFY `public` TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE category DROP public');
        $this->addSql('ALTER TABLE task DROP public');
    }
}
