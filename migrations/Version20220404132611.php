<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220404132611 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hike (id INT AUTO_INCREMENT NOT NULL, difficulty_id INT NOT NULL, name VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, length DOUBLE PRECISION DEFAULT NULL, duration DOUBLE PRECISION DEFAULT NULL, elevation_gain DOUBLE PRECISION DEFAULT NULL, elevation_loss DOUBLE PRECISION DEFAULT NULL, gps_coordonate VARCHAR(255) DEFAULT NULL, INDEX IDX_2301D7E4FCFA9DAE (difficulty_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hike_images (id INT AUTO_INCREMENT NOT NULL, hike_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_6E1FDE1A71D4DE21 (hike_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hike ADD CONSTRAINT FK_2301D7E4FCFA9DAE FOREIGN KEY (difficulty_id) REFERENCES difficulty (id)');
        $this->addSql('ALTER TABLE hike_images ADD CONSTRAINT FK_6E1FDE1A71D4DE21 FOREIGN KEY (hike_id) REFERENCES hike (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hike_images DROP FOREIGN KEY FK_6E1FDE1A71D4DE21');
        $this->addSql('DROP TABLE hike');
        $this->addSql('DROP TABLE hike_images');
    }
}
