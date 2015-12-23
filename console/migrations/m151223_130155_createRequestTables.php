<?php

use console\components\Migration;

class m151223_130155_createRequestTables extends Migration
{
    public function up()
    {
        $this->createTable('request', [
            'id'          => self::PRIMARY_KEY,
            'rubric_id'   => self::INT_FIELD_NOT_NULL,
            'data'        => 'TEXT',
            'user_id'     => self::INT_FIELD_NOT_NULL,
            'date_create' => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_request_rubric_id', 'request', 'rubric_id', 'rubric', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_request_user_id', 'request', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('request_position', [
            'id'          => self::PRIMARY_KEY,
            'request_id'  => self::INT_FIELD_NOT_NULL,
            'description' => 'VARCHAR(500) NOT NULL',
            'comment'     => 'VARCHAR(500) DEFAULT NULL',
            'data'        => 'TEXT',
            'date_create' => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_request_position_request_id', 'request_position', 'request_id',
            'request', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_request_position_request_id', 'request_position');
        $this->dropTable('request_position');

        $this->dropForeignKey('fk_request_user_id', 'request');
        $this->dropForeignKey('fk_request_rubric_id', 'request');
        $this->dropTable('request');
    }
}
