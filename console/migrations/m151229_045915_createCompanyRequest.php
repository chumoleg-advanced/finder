<?php

use console\components\Migration;

class m151229_045915_createCompanyRequest extends Migration
{
    public function up()
    {
        $this->createTable('request_offer', [
            'id'             => self::PRIMARY_KEY,
            'request_id'     => self::INT_FIELD_NOT_NULL,
            'company_id'     => self::INT_FIELD_NOT_NULL,
            'description'    => 'TEXT DEFAULT NULL',
            'status'         => 'TINYINT(1) UNSIGNED DEFAULT 1',
            'price'          => 'DECIMAL(12, 2) UNSIGNED DEFAULT NULL',
            'delivery_price' => 'DECIMAL(12, 2) UNSIGNED DEFAULT NULL',
            'date_create'    => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_request_offer_request_id', 'request_offer', 'request_id',
            'request', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_request_offer_company_id', 'request_offer', 'company_id',
            'company', 'id', 'CASCADE', 'CASCADE');

        $this->addColumn('request', 'request_offer_id', self::INT_FIELD . ' DEFAULT NULL AFTER performer_company_id');
        $this->addForeignKey('fk_request_request_offer_id', 'request', 'request_offer_id',
            'request_offer', 'id', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_request_request_offer_id', 'request');

        $this->dropForeignKey('fk_request_offer_request_id', 'request_offer');
        $this->dropForeignKey('fk_request_offer_company_id', 'request_offer');
        $this->dropTable('request_offer');

        $this->dropColumn('request', 'request_offer_id');
    }
}
