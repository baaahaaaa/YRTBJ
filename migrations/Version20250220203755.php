<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250220203755 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidat CHANGE phone_number phone_number VARCHAR(8) NOT NULL');
        $this->addSql('ALTER TABLE reclamation CHANGE description description LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE user DROP role');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidat CHANGE phone_number phone_number INT NOT NULL');
        $this->addSql('ALTER TABLE reclamation CHANGE description description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE `user` ADD role VARCHAR(255) NOT NULL');
    }
}
