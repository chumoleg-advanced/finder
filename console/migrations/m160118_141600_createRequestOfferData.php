<?php

use console\components\Migration;

class m160118_141600_createRequestOfferData extends Migration
{
    public function up()
    {
        $this->createTable('request_offer_image', [
            'id'               => self::PRIMARY_KEY,
            'request_offer_id' => self::INT_FIELD_NOT_NULL,
            'name'             => 'VARCHAR(250) NOT NULL',
            'thumb_name'       => 'VARCHAR(250) NOT NULL',
            'date_create'      => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_request_offer_image_request_offer_id', 'request_offer_image', 'request_offer_id',
            'request_offer', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('request_offer_attribute', [
            'id'               => self::PRIMARY_KEY,
            'request_offer_id' => self::INT_FIELD_NOT_NULL,
            'attribute_name'   => 'VARCHAR(200) NOT NULL',
            'value'            => 'TEXT',
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_request_offer_attribute_request_offer_id', 'request_offer_attribute',
            'request_offer_id', 'request_offer', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('main_request_offer', [
            'id'          => self::PRIMARY_KEY,
            'user_id'     => self::INT_FIELD_NOT_NULL,
            'request_id'  => self::INT_FIELD_NOT_NULL,
            'status'      => 'TINYINT(1) UNSIGNED DEFAULT 1',
            'date_create' => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_main_request_offer_user_id', 'main_request_offer', 'user_id',
            'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_main_request_offer_request_id', 'main_request_offer', 'request_id',
            'request', 'id', 'CASCADE', 'CASCADE');

        $this->delete('request_offer');
        $this->delete('main_request_offer');
        $this->addColumn('request_offer', 'main_request_offer_id', self::INT_FIELD_NOT_NULL . ' AFTER id');
        $this->addForeignKey('fk_request_offer_main_request_offer_id', 'request_offer', 'main_request_offer_id',
            'main_request_offer', 'id', 'CASCADE', 'CASCADE');

        $this->addColumn('request_offer', 'comment', 'TEXT AFTER description');
    }

    public function down()
    {
        $this->dropForeignKey('fk_request_offer_image_request_offer_id', 'request_offer_image');
        $this->dropTable('request_offer_image');

        $this->dropForeignKey('fk_request_offer_attribute_request_offer_id', 'request_offer_attribute');
        $this->dropTable('request_offer_attribute');

        $this->dropForeignKey('fk_main_request_offer_user_id', 'main_request_offer');
        $this->dropForeignKey('fk_main_request_offer_request_id', 'main_request_offer');
        $this->dropForeignKey('fk_request_offer_main_request_offer_id', 'request_offer');
        $this->dropTable('main_request_offer');

        $this->dropColumn('request_offer', 'main_request_offer_id');
        $this->dropColumn('request_offer', 'comment');
    }
}
