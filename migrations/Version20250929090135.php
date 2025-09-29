<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250929090135 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD firstname VARCHAR(45) NOT NULL, ADD lastname VARCHAR(45) NOT NULL, ADD description VARCHAR(255) NOT NULL, ADD status VARCHAR(45) NOT NULL, ADD instagram VARCHAR(45) NOT NULL, ADD linkedin VARCHAR(45) NOT NULL, ADD facebook VARCHAR(45) NOT NULL, ADD twitter VARCHAR(45) NOT NULL, ADD bannerpic VARCHAR(255) NOT NULL, ADD profilepic VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP firstname, DROP lastname, DROP description, DROP status, DROP instagram, DROP linkedin, DROP facebook, DROP twitter, DROP bannerpic, DROP profilepic');
    }
}
