<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210128123026 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE lead_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE mr_bil_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE mr_lead_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE mr_lead (id INT NOT NULL, status INT NOT NULL, phone VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE mr_lead_mr_book (mr_lead_id INT NOT NULL, mr_book_id INT NOT NULL, PRIMARY KEY(mr_lead_id, mr_book_id))');
        $this->addSql('CREATE INDEX IDX_F0641038F9777C ON mr_lead_mr_book (mr_lead_id)');
        $this->addSql('CREATE INDEX IDX_F0641031E0E8170 ON mr_lead_mr_book (mr_book_id)');
        $this->addSql('ALTER TABLE mr_lead_mr_book ADD CONSTRAINT FK_F0641038F9777C FOREIGN KEY (mr_lead_id) REFERENCES mr_lead (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mr_lead_mr_book ADD CONSTRAINT FK_F0641031E0E8170 FOREIGN KEY (mr_book_id) REFERENCES mr_book (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE mr_bil');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE mr_lead_mr_book DROP CONSTRAINT FK_F0641038F9777C');
        $this->addSql('DROP SEQUENCE mr_lead_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE lead_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE mr_bil_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE mr_bil (id INT NOT NULL, bookid VARCHAR(255) NOT NULL, authorid INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE mr_lead');
        $this->addSql('DROP TABLE mr_lead_mr_book');
    }
}
