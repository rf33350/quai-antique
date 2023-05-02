<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230426141628 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE open_hour (id INT AUTO_INCREMENT NOT NULL, relation_id INT DEFAULT NULL, day VARCHAR(255) NOT NULL, mourning_start_time TIME DEFAULT NULL, mourning_stop_time TIME DEFAULT NULL, evening_start_time TIME DEFAULT NULL, evening_stop_time TIME DEFAULT NULL, INDEX IDX_C9EA506B3256915B (relation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE open_hour ADD CONSTRAINT FK_C9EA506B3256915B FOREIGN KEY (relation_id) REFERENCES restaurant (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE open_hour DROP FOREIGN KEY FK_C9EA506B3256915B');
        $this->addSql('DROP TABLE open_hour');
    }
}
