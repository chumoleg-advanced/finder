<?php

use console\components\Migration;

class m160109_024045_createRequestImage extends Migration
{
    public function up()
    {
        $this->delete('main_request');
        $this->delete('request');
        $this->execute('ALTER TABLE main_request AUTO_INCREMENT = 1');
        $this->execute('ALTER TABLE request AUTO_INCREMENT = 1');

        $this->createTable('request_image', [
            'id'          => self::PRIMARY_KEY,
            'request_id'  => self::INT_FIELD_NOT_NULL,
            'name'        => 'VARCHAR(100) NOT NULL',
            'date_create' => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_request_image_request_id', 'request_image', 'request_id',
            'request', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_request_image_request_id', 'request_image');
        $this->dropTable('request_image');
    }
}
