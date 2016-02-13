<?php

use console\components\Migration;

class m160213_083617_createNotification extends Migration
{
    public function up()
    {
        try {
            $this->dropForeignKey('fk_user_setting_user_id', 'user_setting');
            $this->dropTable('user_setting');
        } catch (\yii\base\Exception $e) {
        }

        $this->addColumn('user', 'fio', 'VARCHAR(200) DEFAULT NULL AFTER phone');
        $this->addColumn('user', 'birthday', 'DATE DEFAULT NULL AFTER fio');

        $this->createTable('notification_setting', [
            'id'          => self::PRIMARY_KEY,
            'user_id'     => self::INT_FIELD_NOT_NULL,
            'type'        => 'TINYINT(3) UNSIGNED NOT NULL',
            'date_create' => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_notification_setting_user_id', 'notification_setting', 'user_id',
            'user', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('notification', [
            'id'          => self::PRIMARY_KEY,
            'user_id'     => self::INT_FIELD_NOT_NULL,
            'type'        => 'TINYINT(3) UNSIGNED NOT NULL',
            'message'     => 'VARCHAR(300) DEFAULT NULL',
            'status'      => 'TINYINT(1) UNSIGNED DEFAULT 1',
            'data'        => 'TEXT',
            'date_create' => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_notification_user_id', 'notification', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropColumn('user', 'fio');
        $this->dropColumn('user', 'birthday');

        $this->dropForeignKey('fk_notification_setting_user_id', 'notification_setting');
        $this->dropTable('notification_setting');

        $this->dropForeignKey('fk_notification_user_id', 'notification');
        $this->dropTable('notification');
    }
}
