<?php

use console\components\Migration;

class m160111_150458_remapCityId extends Migration
{
    public function up()
    {
        try {
            $this->dropForeignKey('fk_company_city_id', 'company');
            $this->dropColumn('company', 'city_id');
        } catch (\yii\base\Exception $e) {
        }

        try {
            $this->addColumn('company_address', 'city_id', self::INT_FIELD . ' DEFAULT NULL AFTER company_id');
            $this->addForeignKey('fk_company_address_city_id', 'company_address', 'city_id',
                'city', 'id', 'SET NULL', 'CASCADE');

            $this->update('company_address', ['city_id' => 1]);
        } catch (\yii\base\Exception $e) {
        }
    }

    public function down()
    {
        $this->dropForeignKey('fk_company_address_city_id', 'company_address');
        $this->dropColumn('company_address', 'city_id');
    }
}
