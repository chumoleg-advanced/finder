<?php

use console\components\Migration;
use common\components\Status;

class m151219_100327_dashBoardTables extends Migration
{
    public function up()
    {
        $this->_createTableCity();
        $this->_createTableUserSetting();

        $this->_createTableCompany();
        $this->_createTableCompanyAddress();
        $this->_createTableCompanyRubric();
        $this->_createTableCompanyContactData();
        $this->_createTableCompanyTypePayment();
        $this->_createTableCompanyTypeDelivery();

        $this->insert('city', [
            'name'        => 'Новосибирск',
            'status'      => Status::STATUS_ACTIVE,
            'date_create' => date('Y-m-d H:i:s')
        ]);
    }

    public function down()
    {
        $this->dropForeignKey('fk_user_setting_user_id', 'user_setting');
        $this->dropTable('user_setting');

        $this->dropForeignKey('fk_company_rubric_company_id', 'company_rubric');
        $this->dropForeignKey('fk_company_rubric_rubric_id', 'company_rubric');
        $this->dropTable('company_rubric');

        $this->dropForeignKey('fk_company_contact_data_company_id', 'company_contact_data');
        $this->dropForeignKey('fk_company_contact_data_company_address_id', 'company_contact_data');
        $this->dropTable('company_contact_data');

        $this->dropForeignKey('fk_company_type_payment_company_id', 'company_type_payment');
        $this->dropTable('company_type_payment');

        $this->dropForeignKey('fk_company_type_delivery_company_id', 'company_type_delivery');
        $this->dropTable('company_type_delivery');

        $this->dropForeignKey('fk_company_address_company_id', 'company_address');
        $this->dropTable('company_address');

        $this->dropForeignKey('fk_company_user_id', 'company');
        $this->dropForeignKey('fk_company_city_id', 'company');
        $this->dropTable('company');

        $this->dropTable('city');
    }

    private function _createTableCity()
    {
        $this->createTable('city', [
            'id'          => self::PRIMARY_KEY,
            'name'        => 'VARCHAR(100) NOT NULL',
            'status'      => 'TINYINT(1) UNSIGNED NOT NULL',
            'date_create' => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);
    }

    private function _createTableUserSetting()
    {
        $this->createTable('user_setting', [
            'id'          => self::PRIMARY_KEY,
            'user_id'     => self::INT_FIELD . ' NOT NULL',
            'data'        => 'TEXT DEFAULT NULL',
            'date_create' => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_user_setting_user_id', 'user_setting', 'user_id',
            'user', 'id', 'CASCADE', 'CASCADE');
    }

    private function _createTableCompany()
    {
        $this->createTable('company', [
            'id'          => self::PRIMARY_KEY,
            'status'      => 'TINYINT(1) UNSIGNED NOT NULL',
            'city_id'     => self::INT_FIELD_NOT_NULL,
            'user_id'     => self::INT_FIELD_NOT_NULL,
            'legal_name'  => 'VARCHAR(250) DEFAULT NULL',
            'actual_name' => 'VARCHAR(250) DEFAULT NULL',
            'form'        => 'TINYINT(1) UNSIGNED NOT NULL',
            'inn'         => 'VARCHAR(12) DEFAULT NULL',
            'ogrn'        => 'VARCHAR(15) DEFAULT NULL',
            'date_create' => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_company_user_id', 'company', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_company_city_id', 'company', 'city_id', 'city', 'id', 'RESTRICT', 'CASCADE');
    }

    private function _createTableCompanyAddress()
    {
        $this->createTable('company_address', [
            'id'              => self::PRIMARY_KEY,
            'company_id'      => self::INT_FIELD_NOT_NULL,
            'address'         => 'VARCHAR(400) NOT NULL',
            'map_coordinates' => 'VARCHAR(200) DEFAULT NULL',
            'time_work'       => 'TEXT DEFAULT NULL',
            'date_create'     => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_company_address_company_id', 'company_address', 'company_id',
            'company', 'id', 'CASCADE', 'CASCADE');
    }

    private function _createTableCompanyRubric()
    {
        $this->createTable('company_rubric', [
            'id'          => self::PRIMARY_KEY,
            'company_id'  => self::INT_FIELD_NOT_NULL,
            'rubric_id'   => self::INT_FIELD_NOT_NULL,
            'date_create' => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_company_rubric_company_id', 'company_rubric', 'company_id',
            'company', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_company_rubric_rubric_id', 'company_rubric', 'rubric_id',
            'rubric', 'id', 'CASCADE', 'CASCADE');
    }

    private function _createTableCompanyContactData()
    {
        $this->createTable('company_contact_data', [
            'id'                 => self::PRIMARY_KEY,
            'company_id'         => self::INT_FIELD_NOT_NULL,
            'company_address_id' => self::INT_FIELD_NOT_NULL,
            'type'               => 'TINYINT(3) UNSIGNED NOT NULL',
            'data'               => 'VARCHAR(200)',
            'date_create'        => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_company_contact_data_company_id', 'company_contact_data', 'company_id',
            'company', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_company_contact_data_company_address_id', 'company_contact_data', 'company_address_id',
            'company_address', 'id', 'CASCADE', 'CASCADE');
    }

    private function _createTableCompanyTypePayment()
    {
        $this->createTable('company_type_payment', [
            'id'          => self::PRIMARY_KEY,
            'company_id'  => self::INT_FIELD_NOT_NULL,
            'type'        => 'TINYINT(2) UNSIGNED NOT NULL',
            'date_create' => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_company_type_payment_company_id', 'company_type_payment', 'company_id',
            'company', 'id', 'CASCADE', 'CASCADE');
    }

    private function _createTableCompanyTypeDelivery()
    {
        $this->createTable('company_type_delivery', [
            'id'          => self::PRIMARY_KEY,
            'company_id'  => self::INT_FIELD_NOT_NULL,
            'type'        => 'TINYINT(2) UNSIGNED NOT NULL',
            'date_create' => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_company_type_delivery_company_id', 'company_type_delivery', 'company_id',
            'company', 'id', 'CASCADE', 'CASCADE');
    }
}