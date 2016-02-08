<?php

use console\components\Migration;

class m160204_130140_createPersonalMessages extends Migration
{
    public function up()
    {
        $this->createTable('message_dialog', [
            'id'           => self::PRIMARY_KEY,
            'request_id'   => self::INT_FIELD_NOT_NULL,
            'sender'       => 'TINYINT(1) UNSIGNED DEFAULT 1',
            'from_user_id' => self::INT_FIELD_NOT_NULL,
            'to_user_id'   => self::INT_FIELD_NOT_NULL,
            'company_id'   => self::INT_FIELD,
            'date_create'  => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_message_dialog_request_id', 'message_dialog', 'request_id',
            'request', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_message_dialog_from_user_id', 'message_dialog', 'from_user_id',
            'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_message_dialog_to_user_id', 'message_dialog', 'to_user_id',
            'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_message_dialog_company_id', 'message_dialog', 'company_id',
            'company', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('message', [
            'id'                => self::PRIMARY_KEY,
            'message_dialog_id' => self::INT_FIELD_NOT_NULL,
            'from_user_id'      => self::INT_FIELD_NOT_NULL,
            'to_user_id'        => self::INT_FIELD_NOT_NULL,
            'data'              => 'TEXT',
            'status'            => 'TINYINT(1) UNSIGNED DEFAULT 1',
            'date_create'       => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_message_message_dialog_id', 'message', 'message_dialog_id',
            'message_dialog', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_message_from_user_id', 'message', 'from_user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_message_to_user_id', 'message', 'to_user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_message_message_dialog_id', 'message');
        $this->dropForeignKey('fk_message_from_user_id', 'message');
        $this->dropForeignKey('fk_message_to_user_id', 'message');
        $this->dropTable('message');

        $this->dropForeignKey('fk_message_dialog_request_id', 'message_dialog');
        $this->dropForeignKey('fk_message_dialog_from_user_id', 'message_dialog');
        $this->dropForeignKey('fk_message_dialog_to_user_id', 'message_dialog');
        $this->dropForeignKey('fk_message_dialog_company_id', 'message_dialog');
        $this->dropTable('message_dialog');
    }
}
