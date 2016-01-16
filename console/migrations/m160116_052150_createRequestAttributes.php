<?php

use console\components\Migration;

class m160116_052150_createRequestAttributes extends Migration
{
    public function up()
    {
        $this->delete('main_request');
        $this->delete('request');

        $this->createTable('request_attribute', [
            'id'             => self::PRIMARY_KEY,
            'request_id'     => self::INT_FIELD_NOT_NULL,
            'attribute_name' => 'VARCHAR(200) NOT NULL',
            'value'          => 'TEXT',
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_request_attribute_request_id', 'request_attribute', 'request_id',
            'request', 'id', 'CASCADE', 'CASCADE');

        try {
            $this->dropColumn('main_request', 'data');
            $this->dropColumn('request', 'data');

        } catch (\yii\base\Exception $e) {
        }
    }

    public function down()
    {
        $this->dropForeignKey('fk_request_attribute_request_id', 'request_attribute');
        $this->dropTable('request_attribute');
    }
}
