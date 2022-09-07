<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220904143710 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE allergies (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE allergies_ingredient (allergies_id INT NOT NULL, ingredient_id INT NOT NULL, INDEX IDX_32937F127104939B (allergies_id), INDEX IDX_32937F12933FE08C (ingredient_id), PRIMARY KEY(allergies_id, ingredient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredient (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pizza (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image_name VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pizza_ingredient (pizza_id INT NOT NULL, ingredient_id INT NOT NULL, INDEX IDX_6FF6C03FD41D1D42 (pizza_id), INDEX IDX_6FF6C03F933FE08C (ingredient_id), PRIMARY KEY(pizza_id, ingredient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, allergie_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D6497C86304A (allergie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE allergies_ingredient ADD CONSTRAINT FK_32937F127104939B FOREIGN KEY (allergies_id) REFERENCES allergies (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE allergies_ingredient ADD CONSTRAINT FK_32937F12933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pizza_ingredient ADD CONSTRAINT FK_6FF6C03FD41D1D42 FOREIGN KEY (pizza_id) REFERENCES pizza (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pizza_ingredient ADD CONSTRAINT FK_6FF6C03F933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6497C86304A FOREIGN KEY (allergie_id) REFERENCES allergies (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE allergies_ingredient DROP FOREIGN KEY FK_32937F127104939B');
        $this->addSql('ALTER TABLE allergies_ingredient DROP FOREIGN KEY FK_32937F12933FE08C');
        $this->addSql('ALTER TABLE pizza_ingredient DROP FOREIGN KEY FK_6FF6C03FD41D1D42');
        $this->addSql('ALTER TABLE pizza_ingredient DROP FOREIGN KEY FK_6FF6C03F933FE08C');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6497C86304A');
        $this->addSql('DROP TABLE allergies');
        $this->addSql('DROP TABLE allergies_ingredient');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE pizza');
        $this->addSql('DROP TABLE pizza_ingredient');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
