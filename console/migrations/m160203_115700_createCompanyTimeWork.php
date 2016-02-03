<?php

use console\components\Migration;

class m160203_115700_createCompanyTimeWork extends Migration
{
    public function up()
    {
        try {
            $this->dropColumn('company_address', 'time_work');
        } catch (\yii\base\Exception $e) {
        }

        $this->createTable('company_address_time_work', [
            'id'                 => self::PRIMARY_KEY,
            'company_address_id' => self::INT_FIELD_NOT_NULL,
            'type'               => 'TINYINT(1) UNSIGNED DEFAULT 1',
            'days_list'          => 'VARCHAR(100)',
            'time_from'          => 'TINYINT(2) UNSIGNED',
            'time_to'            => 'TINYINT(2) UNSIGNED',
            'date_create'        => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_company_address_time_work_company_address_id', 'company_address_time_work',
            'company_address_id', 'company_address', 'id', 'CASCADE', 'CASCADE');

    }

    public function down()
    {
        $this->dropForeignKey('fk_company_address_time_work_company_address_id', 'company_address_time_work');
        $this->dropTable('company_address_time_work');
    }
}
