<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230705182645 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appointment (id INT AUTO_INCREMENT NOT NULL, type_rdv_id INT DEFAULT NULL, doctor_id INT DEFAULT NULL, patient_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', heure_debut TIME NOT NULL, heure_fin TIME NOT NULL, INDEX IDX_FE38F8446F1954BE (type_rdv_id), INDEX IDX_FE38F84487F4FB17 (doctor_id), INDEX IDX_FE38F8446B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doctor (id INT NOT NULL, subscription_id INT DEFAULT NULL, specialty_id INT DEFAULT NULL, disponibilite TINYINT(1) NOT NULL, INDEX IDX_1FC0F36A9A1887DC (subscription_id), INDEX IDX_1FC0F36A9A353316 (specialty_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE infos (id INT AUTO_INCREMENT NOT NULL, doctor_id INT DEFAULT NULL, carte VARCHAR(255) NOT NULL, presentation VARCHAR(255) NOT NULL, horaire DATE DEFAULT NULL, tarif DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_EECA826D87F4FB17 (doctor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notice (id INT AUTO_INCREMENT NOT NULL, patient_id INT NOT NULL, INDEX IDX_480D45C26B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient (id INT NOT NULL, appointment_id INT DEFAULT NULL, assurance VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, INDEX IDX_1ADAD7EBE5B533F9 (appointment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE speciality (id INT AUTO_INCREMENT NOT NULL, nom_speciality VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscription (id INT AUTO_INCREMENT NOT NULL, tarif DOUBLE PRECISION NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_rdv (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, cin VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, photp VARCHAR(30) NOT NULL, login VARCHAR(20) NOT NULL, password VARCHAR(30) NOT NULL, sexe VARCHAR(10) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F8446F1954BE FOREIGN KEY (type_rdv_id) REFERENCES type_rdv (id)');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F84487F4FB17 FOREIGN KEY (doctor_id) REFERENCES doctor (id)');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F8446B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE doctor ADD CONSTRAINT FK_1FC0F36A9A1887DC FOREIGN KEY (subscription_id) REFERENCES subscription (id)');
        $this->addSql('ALTER TABLE doctor ADD CONSTRAINT FK_1FC0F36A9A353316 FOREIGN KEY (specialty_id) REFERENCES speciality (id)');
        $this->addSql('ALTER TABLE doctor ADD CONSTRAINT FK_1FC0F36ABF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE infos ADD CONSTRAINT FK_EECA826D87F4FB17 FOREIGN KEY (doctor_id) REFERENCES doctor (id)');
        $this->addSql('ALTER TABLE notice ADD CONSTRAINT FK_480D45C26B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EBE5B533F9 FOREIGN KEY (appointment_id) REFERENCES appointment (id)');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EBBF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F8446F1954BE');
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F84487F4FB17');
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F8446B899279');
        $this->addSql('ALTER TABLE doctor DROP FOREIGN KEY FK_1FC0F36A9A1887DC');
        $this->addSql('ALTER TABLE doctor DROP FOREIGN KEY FK_1FC0F36A9A353316');
        $this->addSql('ALTER TABLE doctor DROP FOREIGN KEY FK_1FC0F36ABF396750');
        $this->addSql('ALTER TABLE infos DROP FOREIGN KEY FK_EECA826D87F4FB17');
        $this->addSql('ALTER TABLE notice DROP FOREIGN KEY FK_480D45C26B899279');
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EBE5B533F9');
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EBBF396750');
        $this->addSql('DROP TABLE appointment');
        $this->addSql('DROP TABLE doctor');
        $this->addSql('DROP TABLE infos');
        $this->addSql('DROP TABLE notice');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE speciality');
        $this->addSql('DROP TABLE subscription');
        $this->addSql('DROP TABLE type_rdv');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
