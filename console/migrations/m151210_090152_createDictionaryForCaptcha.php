<?php

use console\components\Migration;

class m151210_090152_createDictionaryForCaptcha extends Migration
{
    public function up()
    {
        $this->createTable('dictionary', [
            'id'   => self::PRIMARY_KEY,
            'name' => 'VARCHAR(15) NOT NULL'
        ], self::TABLE_OPTIONS);
    }

    public function down()
    {
        $this->dropTable('dictionary');
    }
}
