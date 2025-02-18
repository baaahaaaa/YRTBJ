<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250217193300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE course_student (course_id INT NOT NULL, student_id INT NOT NULL, INDEX IDX_BFE0AADF591CC992 (course_id), INDEX IDX_BFE0AADFCB944F1A (student_id), PRIMARY KEY(course_id, student_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE course_student ADD CONSTRAINT FK_BFE0AADF591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_student ADD CONSTRAINT FK_BFE0AADFCB944F1A FOREIGN KEY (student_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course ADD tutor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9208F64F1 FOREIGN KEY (tutor_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_169E6FB9208F64F1 ON course (tutor_id)');
        $this->addSql('ALTER TABLE ressource ADD courses_id INT DEFAULT NULL, ADD file_path VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE ressource ADD CONSTRAINT FK_939F4544F9295384 FOREIGN KEY (courses_id) REFERENCES course (id)');
        $this->addSql('CREATE INDEX IDX_939F4544F9295384 ON ressource (courses_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course_student DROP FOREIGN KEY FK_BFE0AADF591CC992');
        $this->addSql('ALTER TABLE course_student DROP FOREIGN KEY FK_BFE0AADFCB944F1A');
        $this->addSql('DROP TABLE course_student');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB9208F64F1');
        $this->addSql('DROP INDEX IDX_169E6FB9208F64F1 ON course');
        $this->addSql('ALTER TABLE course DROP tutor_id');
        $this->addSql('ALTER TABLE ressource DROP FOREIGN KEY FK_939F4544F9295384');
        $this->addSql('DROP INDEX IDX_939F4544F9295384 ON ressource');
        $this->addSql('ALTER TABLE ressource DROP courses_id, DROP file_path');
    }
}
