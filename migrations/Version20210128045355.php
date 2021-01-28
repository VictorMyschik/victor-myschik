<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210128045355 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE mr_author_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE mr_bil_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE mr_book_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE mr_author (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE mr_bil (id INT NOT NULL, bookid VARCHAR(255) NOT NULL, authorid INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE mr_book (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE mr_book_mr_author (mr_book_id INT NOT NULL, mr_author_id INT NOT NULL, PRIMARY KEY(mr_book_id, mr_author_id))');
        $this->addSql('CREATE INDEX IDX_95D6DF701E0E8170 ON mr_book_mr_author (mr_book_id)');
        $this->addSql('CREATE INDEX IDX_95D6DF7033057ACB ON mr_book_mr_author (mr_author_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, title VARCHAR(255) NOT NULL, actual BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE mr_book_mr_author ADD CONSTRAINT FK_95D6DF701E0E8170 FOREIGN KEY (mr_book_id) REFERENCES mr_book (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mr_book_mr_author ADD CONSTRAINT FK_95D6DF7033057ACB FOREIGN KEY (mr_author_id) REFERENCES mr_author (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE mr_book_mr_author DROP CONSTRAINT FK_95D6DF7033057ACB');
        $this->addSql('ALTER TABLE mr_book_mr_author DROP CONSTRAINT FK_95D6DF701E0E8170');
        $this->addSql('DROP SEQUENCE mr_author_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE mr_bil_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE mr_book_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('DROP TABLE mr_author');
        $this->addSql('DROP TABLE mr_bil');
        $this->addSql('DROP TABLE mr_book');
        $this->addSql('DROP TABLE mr_book_mr_author');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE users');
    }
}
