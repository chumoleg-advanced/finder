<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id'                   => 'INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'username'             => 'VARCHAR(20) NOT NULL',
            'email'                => 'VARCHAR(64) NOT NULL',
            'password_hash'        => 'CHAR(60) NULL',
            'password_reset_token' => 'CHAR(44) NULL',
            'phone'                => 'VARCHAR(14)',
            'auth_key'             => 'CHAR(32) NOT NULL',
            'status'               => 'TINYINT UNSIGNED NOT NULL',
            'created_at'           => 'DATETIME NOT NULL',
            'updated_at'           => 'DATETIME NOT NULL',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
