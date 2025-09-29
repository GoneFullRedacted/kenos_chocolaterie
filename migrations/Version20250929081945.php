<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250929081945 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64964D218E');
        $this->addSql('DROP INDEX IDX_8D93D64964D218E ON user');
        $this->addSql('ALTER TABLE user ADD roles JSON NOT NULL COMMENT \'(DC2Type:json)\', DROP location_id, DROP firstname, DROP lastname, DROP role, DROP description, DROP status, DROP instagram, DROP linkedin, DROP facebook, DROP twitter, DROP bannerpic, DROP profilepic, CHANGE email email VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_EMAIL ON user');
        $this->addSql('ALTER TABLE user ADD location_id INT DEFAULT NULL, ADD firstname VARCHAR(45) NOT NULL, ADD lastname VARCHAR(45) NOT NULL, ADD role VARCHAR(45) NOT NULL, ADD description VARCHAR(255) DEFAULT NULL, ADD status VARCHAR(45) NOT NULL, ADD instagram VARCHAR(255) DEFAULT NULL, ADD linkedin VARCHAR(255) DEFAULT NULL, ADD facebook VARCHAR(255) DEFAULT NULL, ADD twitter VARCHAR(255) DEFAULT NULL, ADD bannerpic VARCHAR(255) DEFAULT NULL, ADD profilepic VARCHAR(255) DEFAULT NULL, DROP roles, CHANGE email email INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64964D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64964D218E ON user (location_id)');
    }
}
