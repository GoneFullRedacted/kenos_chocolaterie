<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250922070701 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE postcomment ADD user_id INT DEFAULT NULL, ADD post_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE postcomment ADD CONSTRAINT FK_5D65518AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE postcomment ADD CONSTRAINT FK_5D65518A4B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('CREATE INDEX IDX_5D65518AA76ED395 ON postcomment (user_id)');
        $this->addSql('CREATE INDEX IDX_5D65518A4B89032C ON postcomment (post_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE postcomment DROP FOREIGN KEY FK_5D65518AA76ED395');
        $this->addSql('ALTER TABLE postcomment DROP FOREIGN KEY FK_5D65518A4B89032C');
        $this->addSql('DROP INDEX IDX_5D65518AA76ED395 ON postcomment');
        $this->addSql('DROP INDEX IDX_5D65518A4B89032C ON postcomment');
        $this->addSql('ALTER TABLE postcomment DROP user_id, DROP post_id');
    }
}
