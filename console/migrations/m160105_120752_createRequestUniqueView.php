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
    }

    public function down()
    {
        $this->dropTable('request_view');
    }
}
