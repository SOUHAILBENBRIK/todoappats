<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250221122558 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE priority (id SERIAL NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, level INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_62A6DC27A76ED395 ON priority (user_id)');
        $this->addSql('CREATE TABLE status (id SERIAL NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7B00651CA76ED395 ON status (user_id)');
        $this->addSql('ALTER TABLE priority ADD CONSTRAINT FK_62A6DC27A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE status ADD CONSTRAINT FK_7B00651CA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task ADD priority_id INT NOT NULL');
        $this->addSql('ALTER TABLE task ADD status_id INT NOT NULL');
        $this->addSql('ALTER TABLE task ADD picture VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE task DROP completed');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25497B19F9 FOREIGN KEY (priority_id) REFERENCES priority (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB256BF700BD FOREIGN KEY (status_id) REFERENCES status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_527EDB25497B19F9 ON task (priority_id)');
        $this->addSql('CREATE INDEX IDX_527EDB256BF700BD ON task (status_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE task DROP CONSTRAINT FK_527EDB25497B19F9');
        $this->addSql('ALTER TABLE task DROP CONSTRAINT FK_527EDB256BF700BD');
        $this->addSql('ALTER TABLE priority DROP CONSTRAINT FK_62A6DC27A76ED395');
        $this->addSql('ALTER TABLE status DROP CONSTRAINT FK_7B00651CA76ED395');
        $this->addSql('DROP TABLE priority');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP INDEX IDX_527EDB25497B19F9');
        $this->addSql('DROP INDEX IDX_527EDB256BF700BD');
        $this->addSql('ALTER TABLE task ADD completed BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE task DROP priority_id');
        $this->addSql('ALTER TABLE task DROP status_id');
        $this->addSql('ALTER TABLE task DROP picture');
    }
}
