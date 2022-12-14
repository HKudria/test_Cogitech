<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221214201457 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('
            CREATE TABLE posts 
            (id SERIAL PRIMARY KEY, 
            post_id INT NOT NULL, 
            user_id INT NOT NULL, 
            user_name VARCHAR(180) NOT NULL, 
            title VARCHAR(500) NOT NULL, 
            body VARCHAR(2000) NOT NULL)
        ');

        $this->addSql('
            CREATE TABLE users
            (id SERIAL PRIMARY KEY, 
            email VARCHAR(180) NOT NULL, 
            roles JSON NOT NULL, 
            password VARCHAR(255) NOT NULL)
        ');

        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON users (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE posts');
        $this->addSql('DROP TABLE "user"');
    }
}
