<?php

use console\components\Migration;

class m160221_070835_addStatusMessageDialog extends Migration
{
    public function up()
    {
        $this->addColumn('message_dialog', 'status', 'TINYINT(1) UNSIGNED DEFAULT 0 AFTER company_id');
        $this->update('message_dialog', ['status' => \common\components\Status::STATUS_ACTIVE]);
    }

    public function down()
    {
        $this->dropColumn('message_dialog', 'status');
    }
}
