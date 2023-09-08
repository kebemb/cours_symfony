<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230831091949 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ville (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(70) NOT NULL, code_postal VARCHAR(5) NOT NULL, superficie INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bien ADD ville_id INT NOT NULL');

        $this->addSql('INSERT INTO ville (nom, code_postal) VALUES ("Ville bidon", "00000")');
        $this->addSql('UPDATE bien SET ville_id = 1');

        $this->addSql('ALTER TABLE bien ADD CONSTRAINT FK_45EDC386A73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id)');
        $this->addSql('CREATE INDEX IDX_45EDC386A73F0036 ON bien (ville_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bien DROP FOREIGN KEY FK_45EDC386A73F0036');
        $this->addSql('DROP TABLE ville');
        $this->addSql('DROP INDEX IDX_45EDC386A73F0036 ON bien');
        $this->addSql('ALTER TABLE bien DROP ville_id');
    }
}
