<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InitialMigration extends Migration
{
    public function up()
    {
        // Countries table
        $this->forge->addField([
            'Id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'Name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
        ]);
        $this->forge->addKey('Id', true);
        $this->forge->createTable('Countries');

        // Cities table
        $this->forge->addField([
            'Id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'Name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'CountryId' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
        ]);
        $this->forge->addKey('Id', true);
        $this->forge->addForeignKey('CountryId', 'Countries', 'Id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Cities');

        // Roles table
        $this->forge->addField([
            'Id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'Name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
        ]);
        $this->forge->addKey('Id', true);
        $this->forge->createTable('Roles');

        // Users table
        $this->forge->addField([
            'Id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'Login' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'HashedPassword' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'Email' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'RoleId' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'Discount' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'LastAuthenticationToken' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'Avatar' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
        ]);
        $this->forge->addKey('Id', true);
        $this->forge->addForeignKey('RoleId', 'Roles', 'Id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Users');

        // Hotels table
        $this->forge->addField([
            'Id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'Name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'CountryId' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'CityId' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'Stars' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'Cost' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'Info' => [
                'type' => 'TEXT',
            ],
        ]);
        $this->forge->addKey('Id', true);
        $this->forge->addForeignKey('CountryId', 'Countries', 'Id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('CityId', 'Cities', 'Id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Hotels');

        // Images table
        $this->forge->addField([
            'Id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'HotelId' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'ImagePath' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
        ]);
        $this->forge->addKey('Id', true);
        $this->forge->addForeignKey('HotelId', 'Hotels', 'Id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Images');
    }

    public function down()
    {
        $this->forge->dropTable('Images');
        $this->forge->dropTable('Hotels');
        $this->forge->dropTable('Users');
        $this->forge->dropTable('Roles');
        $this->forge->dropTable('Cities');
        $this->forge->dropTable('Countries');
    }
}
