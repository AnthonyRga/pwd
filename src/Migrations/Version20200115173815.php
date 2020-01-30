<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200115173815 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE pwd_article_store (pwd_article_id INT NOT NULL, store_id INT NOT NULL, INDEX IDX_B18D47ADAD5F2021 (pwd_article_id), INDEX IDX_B18D47ADB092A811 (store_id), PRIMARY KEY(pwd_article_id, store_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pwd_article_store ADD CONSTRAINT FK_B18D47ADAD5F2021 FOREIGN KEY (pwd_article_id) REFERENCES pwd_article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pwd_article_store ADD CONSTRAINT FK_B18D47ADB092A811 FOREIGN KEY (store_id) REFERENCES store (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pwd_article DROP FOREIGN KEY FK_93EF9D24B092A811');
        $this->addSql('DROP INDEX IDX_93EF9D24B092A811 ON pwd_article');
        $this->addSql('ALTER TABLE pwd_article DROP store_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE pwd_article_store');
        $this->addSql('ALTER TABLE pwd_article ADD store_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pwd_article ADD CONSTRAINT FK_93EF9D24B092A811 FOREIGN KEY (store_id) REFERENCES store (id)');
        $this->addSql('CREATE INDEX IDX_93EF9D24B092A811 ON pwd_article (store_id)');
    }
}
