<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241231125210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE note 
            (
                id SERIAL NOT NULL, 
                category_id INT DEFAULT NULL, 
                user_id INT NOT NULL, 
                title VARCHAR(255) DEFAULT NULL, 
                text TEXT DEFAULT NULL, 
                updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id)
            )'
        );
        $this->addSql('CREATE INDEX note_user_category_updated_idx ON note (user_id, category_id, updated_at)');
        $this->addSql('CREATE INDEX note_category_idx ON note (category_id)');

        $this->addSql('CREATE TABLE notes_category 
            (
                id SERIAL NOT NULL, 
                user_id INT NOT NULL, 
                name VARCHAR(255) NOT NULL, PRIMARY KEY(id)
            )'
        );
        $this->addSql('
            ALTER TABLE note 
            ADD CONSTRAINT note_to_notes_category_fk 
            FOREIGN KEY (category_id) 
            REFERENCES notes_category (id) 
            ON DELETE SET NULL
            ON UPDATE CASCADE
            NOT DEFERRABLE INITIALLY IMMEDIATE
        ');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX note_user_category_updated_idx');
        $this->addSql('DROP INDEX note_category_idx');

        $this->addSql('ALTER TABLE note DROP CONSTRAINT note_to_notes_category_fk');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE notes_category');
    }
}
