<?php

use console\components\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $this->createTable('{{%user}}', [
            'id'                   => self::PRIMARY_KEY,
            'username'             => 'VARCHAR(20) NOT NULL',
            'email'                => 'VARCHAR(64) NOT NULL',
            'password_hash'        => 'CHAR(60) NULL',
            'password_reset_token' => 'CHAR(44) NULL',
            'phone'                => 'VARCHAR(14)',
            'auth_key'             => 'CHAR(32) NOT NULL',
            'status'               => 'TINYINT UNSIGNED NOT NULL',
            'created_at'           => self::TIMESTAMP_FIELD,
            'updated_at'           => self::TIMESTAMP_FIELD,
        ], self::TABLE_OPTIONS);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
