<?php

use console\components\Migration;

class m151216_150206_deleteUsername extends Migration
{
    public function up()
    {
        $this->dropColumn('user', 'username');
    }

    public function down()
    {
    }
}
