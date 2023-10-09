<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231009180146 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenements DROP FOREIGN KEY FK_E10AD4006BB0CC12');
        $this->addSql('DROP INDEX IDX_E10AD4006BB0CC12 ON evenements');
        $this->addSql('ALTER TABLE evenements CHANGE id_createur_id createur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evenements ADD CONSTRAINT FK_E10AD40073A201E5 FOREIGN KEY (createur_id) REFERENCES utilisateurs (id)');
        $this->addSql('CREATE INDEX IDX_E10AD40073A201E5 ON evenements (createur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenements DROP FOREIGN KEY FK_E10AD40073A201E5');
        $this->addSql('DROP INDEX IDX_E10AD40073A201E5 ON evenements');
        $this->addSql('ALTER TABLE evenements CHANGE createur_id id_createur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evenements ADD CONSTRAINT FK_E10AD4006BB0CC12 FOREIGN KEY (id_createur_id) REFERENCES utilisateurs (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_E10AD4006BB0CC12 ON evenements (id_createur_id)');
    }
}
