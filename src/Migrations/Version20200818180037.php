<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200818180037 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE invitation (id INT AUTO_INCREMENT NOT NULL, user_sender_id INT NOT NULL, user_invited_id INT NOT NULL, message VARCHAR(255) DEFAULT NULL, accept TINYINT(1) NOT NULL, cancel TINYINT(1) NOT NULL, INDEX IDX_F11D61A2F6C43E79 (user_sender_id), INDEX IDX_F11D61A2658A81AB (user_invited_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(25) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(45) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE invitation ADD CONSTRAINT FK_F11D61A2F6C43E79 FOREIGN KEY (user_sender_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE invitation ADD CONSTRAINT FK_F11D61A2658A81AB FOREIGN KEY (user_invited_id) REFERENCES users (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE invitation DROP FOREIGN KEY FK_F11D61A2F6C43E79');
        $this->addSql('ALTER TABLE invitation DROP FOREIGN KEY FK_F11D61A2658A81AB');
        $this->addSql('DROP TABLE invitation');
        $this->addSql('DROP TABLE users');
    }
}
