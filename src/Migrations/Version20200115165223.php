<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200115165223 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FAD5F2021');
        $this->addSql('DROP INDEX IDX_C53D045FAD5F2021 ON image');
        $this->addSql('ALTER TABLE image ADD name VARCHAR(255) NOT NULL, DROP pwd_article_id, DROP filename, DROP path');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE image ADD pwd_article_id INT DEFAULT NULL, ADD path VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE name filename VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FAD5F2021 FOREIGN KEY (pwd_article_id) REFERENCES pwd_article (id)');
        $this->addSql('CREATE INDEX IDX_C53D045FAD5F2021 ON image (pwd_article_id)');
    }
}
