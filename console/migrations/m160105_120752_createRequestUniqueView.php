<?php

use console\components\Migration;

class m160105_120752_createRequestUniqueView extends Migration
{
    public function up()
    {
        $this->createTable('request_view', [
            'id'          => self::PRIMARY_KEY,
            'request_id'  => self::INT_FIELD_NOT_NULL,
            'user_ip'     => self::INT_FIELD_NOT_NULL,
            'date_create' => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        try {
            $this->addForeignKey('fk_request_id_request_view', 'request_view', 'request_id',
                'request', 'id', 'CASCADE', 'CASCADE');
        } catch (\yii\base\Exception $e){
        }
    }

    public function down()
    {
        try {
            $this->dropForeignKey('fk_request_id_request_view', 'request_view');
        } catch (\yii\base\Exception $e){
        }

        $this->dropTable('request_view');
    }
}
