<?php

use console\components\Migration;

class m160108_050244_createMainRequest extends Migration
{
    public function up()
    {
        $this->delete('request');

        $this->createTable('main_request', [
            'id'          => self::PRIMARY_KEY,
            'user_id'     => self::INT_FIELD_NOT_NULL,
            'rubric_id'   => self::INT_FIELD_NOT_NULL,
            'status'      => 'TINYINT(1) UNSIGNED DEFAULT 1',
            'data'        => 'TEXT DEFAULT NULL',
            'date_create' => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_main_request_user_id', 'main_request', 'user_id',
            'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_main_request_rubric_id', 'main_request', 'rubric_id',
            'rubric', 'id', 'CASCADE', 'CASCADE');

        $this->addColumn('request', 'main_request_id', self::INT_FIELD_NOT_NULL . ' AFTER id');
        $this->addForeignKey('fk_request_main_request_id', 'request', 'main_request_id',
            'main_request', 'id', 'CASCADE', 'CASCADE');

        $this->addColumn('request', 'id_for_client', 'VARCHAR(15) NOT NULL AFTER main_request_id');
        $this->createIndex('id_for_client', 'request', 'id_for_client', true);
    }

    public function down()
    {
        $this->dropForeignKey('fk_request_main_request_id', 'request');
        $this->dropColumn('request', 'main_request_id');
        $this->dropColumn('request', 'id_for_client');

        $this->dropForeignKey('fk_main_request_user_id', 'main_request');
        $this->dropForeignKey('fk_main_request_rubric_id', 'main_request');
        $this->dropTable('main_request');
    }
}
