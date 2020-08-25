<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200824184937 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // étapes pour ajoutter une colonne NOT NULL et unique sur un table avec des lignes dèjà existantes

        // 1. Ajouter la colonne en acceptatnt la valeur NULL
        $this->addSql('ALTER TABLE user ADD pseudo VARCHAR(50) DEFAULT NULL');

        // 2. Définir uns valeur à la nouvelle colonne pour toutes les lignes
        // La valeur va se baser sur la clé primaire pour ^tre unique
        $this->addSql('UPDATE user SET pseudo=CONCAT("pseudo", id)');

        // 3. Remettre la colonne en NOT NULL
        $this->addSql('ALTER TABLE user MODIFY pseudo VARCHAR(50) NOT NULL');

        // 4. Rendre la colonne unique
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64986CC499D ON user (pseudo)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_8D93D64986CC499D ON user');
        $this->addSql('ALTER TABLE user DROP pseudo');
    }
}
