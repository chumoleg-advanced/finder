<?php

use console\components\Migration;

class m160113_151703_createImageThumb extends Migration
{
    public function up()
    {
        $this->addColumn('request_image', 'thumb_name', 'VARCHAR(250) AFTER name');
    }

    public function down()
    {
        $this->dropColumn('request_image', 'thumb_name');
    }
}
