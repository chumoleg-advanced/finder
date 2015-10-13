<?php

use yii\db\Migration;

class m151013_060723_createAuth extends Migration
{
    public function up()
    {
        $this->createTable('oauth', [
            'id'        => 'INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'user_id'   => 'INT(10) UNSIGNED NOT NULL',
            'source'    => 'VARCHAR(255) NOT NULL',
            'source_id' => 'VARCHAR(255) NOT NULL',
        ], 'Engine=InnoDB Charset=UTF8');

        $this->addForeignKey('fk_oauth_user_id', 'oauth', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_oauth_user_id', 'oauth');
        $this->dropTable('oauth');
    }
}
