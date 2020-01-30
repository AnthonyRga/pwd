<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200108172506 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comment ADD pwd_article_id INT NOT NULL, ADD content LONGTEXT NOT NULL, DROP comment');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CAD5F2021 FOREIGN KEY (pwd_article_id) REFERENCES pwd_article (id)');
        $this->addSql('CREATE INDEX IDX_9474526CAD5F2021 ON comment (pwd_article_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CAD5F2021');
        $this->addSql('DROP INDEX IDX_9474526CAD5F2021 ON comment');
        $this->addSql('ALTER TABLE comment ADD comment VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP pwd_article_id, DROP content');
    }
}
