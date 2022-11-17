<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221110124536 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reclamation MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON reclamation');
        $this->addSql('ALTER TABLE reclamation ADD nom VARCHAR(255) NOT NULL, DROP id, DROP date, CHANGE idrec idrec INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE reclamation ADD PRIMARY KEY (idrec)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reclamation ADD id INT AUTO_INCREMENT NOT NULL, ADD date DATE NOT NULL, DROP nom, CHANGE idrec idrec INT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
    }
}
