<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260502000001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'TP4 - Migrate User entity: add roles (JSON) and password columns, drop old role column';
    }

   public function up(Schema $schema): void
    {
    $this->addSql("ALTER TABLE `user` ADD roles JSON NOT NULL");
    $this->addSql("ALTER TABLE `user` ADD password VARCHAR(255) NOT NULL");
    }

    public function down(Schema $schema): void
    {
    $this->addSql("ALTER TABLE `user` DROP COLUMN roles");
    $this->addSql("ALTER TABLE `user` DROP COLUMN password");
    }
}
