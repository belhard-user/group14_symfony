<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180310155800 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE operator_driver (operator_id INT NOT NULL, driver_id INT NOT NULL, INDEX IDX_86C9B05C584598A3 (operator_id), INDEX IDX_86C9B05CC3423909 (driver_id), PRIMARY KEY(operator_id, driver_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE operator_driver ADD CONSTRAINT FK_86C9B05C584598A3 FOREIGN KEY (operator_id) REFERENCES operators (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE operator_driver ADD CONSTRAINT FK_86C9B05CC3423909 FOREIGN KEY (driver_id) REFERENCES drivers (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE operator_driver');
    }
}
