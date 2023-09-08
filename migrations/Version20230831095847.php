<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230831095847 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE food_truck (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, type_cuisine VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE food_truck_ville (food_truck_id INT NOT NULL, ville_id INT NOT NULL, INDEX IDX_63AEBED7EED85B8C (food_truck_id), INDEX IDX_63AEBED7A73F0036 (ville_id), PRIMARY KEY(food_truck_id, ville_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE food_truck_ville ADD CONSTRAINT FK_63AEBED7EED85B8C FOREIGN KEY (food_truck_id) REFERENCES food_truck (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE food_truck_ville ADD CONSTRAINT FK_63AEBED7A73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE food_truck_ville DROP FOREIGN KEY FK_63AEBED7EED85B8C');
        $this->addSql('ALTER TABLE food_truck_ville DROP FOREIGN KEY FK_63AEBED7A73F0036');
        $this->addSql('DROP TABLE food_truck');
        $this->addSql('DROP TABLE food_truck_ville');
    }
}
