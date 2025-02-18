<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250217171452 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, subject VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, user_name VARCHAR(255) NOT NULL, statut VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, createdat DATETIME NOT NULL, updatedat DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse (id INT AUTO_INCREMENT NOT NULL, reclamation_id INT NOT NULL, description VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_5FB6DEC72D6BA2D9 (reclamation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC72D6BA2D9 FOREIGN KEY (reclamation_id) REFERENCES reclamation (id)');
        $this->addSql('DROP TABLE complaint');
        $this->addSql('DROP TABLE complaint_response');
        $this->addSql('ALTER TABLE candidat ADD internship_id INT DEFAULT NULL, ADD student_id INT DEFAULT NULL, ADD cv_filename VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE candidat ADD CONSTRAINT FK_6AB5B4717A4A70BE FOREIGN KEY (internship_id) REFERENCES internship (id)');
        $this->addSql('ALTER TABLE candidat ADD CONSTRAINT FK_6AB5B471CB944F1A FOREIGN KEY (student_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_6AB5B4717A4A70BE ON candidat (internship_id)');
        $this->addSql('CREATE INDEX IDX_6AB5B471CB944F1A ON candidat (student_id)');
        $this->addSql('ALTER TABLE internship ADD agent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE internship ADD CONSTRAINT FK_10D1B00C3414710B FOREIGN KEY (agent_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_10D1B00C3414710B ON internship (agent_id)');
        $this->addSql('ALTER TABLE reservation ADD event_id INT NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495571F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('CREATE INDEX IDX_42C8495571F7E88B ON reservation (event_id)');
        $this->addSql('ALTER TABLE user CHANGE entry_date entry_date DATE DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE complaint (id INT AUTO_INCREMENT NOT NULL, subject VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, message VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date_soumission DATE NOT NULL, status VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE complaint_response (id INT AUTO_INCREMENT NOT NULL, response VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date_response DATE NOT NULL, email_sender VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC72D6BA2D9');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('ALTER TABLE candidat DROP FOREIGN KEY FK_6AB5B4717A4A70BE');
        $this->addSql('ALTER TABLE candidat DROP FOREIGN KEY FK_6AB5B471CB944F1A');
        $this->addSql('DROP INDEX IDX_6AB5B4717A4A70BE ON candidat');
        $this->addSql('DROP INDEX IDX_6AB5B471CB944F1A ON candidat');
        $this->addSql('ALTER TABLE candidat DROP internship_id, DROP student_id, DROP cv_filename');
        $this->addSql('ALTER TABLE internship DROP FOREIGN KEY FK_10D1B00C3414710B');
        $this->addSql('DROP INDEX IDX_10D1B00C3414710B ON internship');
        $this->addSql('ALTER TABLE internship DROP agent_id');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495571F7E88B');
        $this->addSql('DROP INDEX IDX_42C8495571F7E88B ON reservation');
        $this->addSql('ALTER TABLE reservation DROP event_id');
        $this->addSql('ALTER TABLE `user` CHANGE entry_date entry_date DATE NOT NULL');
    }
}
