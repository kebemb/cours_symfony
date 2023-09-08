<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230907090544 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bien_user (id INT AUTO_INCREMENT NOT NULL, bien_id INT NOT NULL, user_id INT NOT NULL, date_acces DATE NOT NULL, INDEX IDX_A6DC5A3BBD95B80F (bien_id), INDEX IDX_A6DC5A3BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bien_user ADD CONSTRAINT FK_A6DC5A3BBD95B80F FOREIGN KEY (bien_id) REFERENCES bien (id)');
        $this->addSql('ALTER TABLE bien_user ADD CONSTRAINT FK_A6DC5A3BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bien_user DROP FOREIGN KEY FK_A6DC5A3BBD95B80F');
        $this->addSql('ALTER TABLE bien_user DROP FOREIGN KEY FK_A6DC5A3BA76ED395');
        $this->addSql('DROP TABLE bien_user');
    }
}
