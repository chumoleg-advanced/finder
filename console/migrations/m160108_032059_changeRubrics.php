<?php

use console\components\Migration;

class m160108_032059_changeRubrics extends Migration
{
    public function up()
    {
        $this->delete('request');
        $this->delete('rubric', 'id IN (10, 11)');
        $this->update('rubric', ['name' => 'Автозапчасти для иномарок'], 'id = 9');
    }

    public function down()
    {
    }
}
