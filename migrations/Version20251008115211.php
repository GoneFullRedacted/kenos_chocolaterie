<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251008115211 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articlepic ADD alttxt VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE postpic ADD alttxt VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE description description TEXT NOT NULL, CHANGE status status VARCHAR(45) NOT NULL, CHANGE instagram instagram VARCHAR(45) NOT NULL, CHANGE linkedin linkedin VARCHAR(45) NOT NULL, CHANGE facebook facebook VARCHAR(45) NOT NULL, CHANGE twitter twitter VARCHAR(45) NOT NULL, CHANGE bannerpic bannerpic VARCHAR(255) NOT NULL, CHANGE profilepic profilepic VARCHAR(255) NOT NULL, CHANGE is_verified is_verified TINYINT(1) NOT NULL, CHANGE is_approved_by_admin is_approved_by_admin TINYINT(1) DEFAULT 0 NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articlepic DROP alttxt');
        $this->addSql('ALTER TABLE postpic DROP alttxt');
        $this->addSql('ALTER TABLE user CHANGE description description TEXT DEFAULT NULL, CHANGE status status VARCHAR(45) DEFAULT NULL, CHANGE instagram instagram VARCHAR(45) DEFAULT NULL, CHANGE linkedin linkedin VARCHAR(45) DEFAULT NULL, CHANGE facebook facebook VARCHAR(45) DEFAULT NULL, CHANGE twitter twitter VARCHAR(45) DEFAULT NULL, CHANGE bannerpic bannerpic VARCHAR(255) DEFAULT NULL, CHANGE profilepic profilepic VARCHAR(255) DEFAULT NULL, CHANGE is_verified is_verified TINYINT(1) DEFAULT NULL, CHANGE is_approved_by_admin is_approved_by_admin TINYINT(1) DEFAULT 0');
    }
}
