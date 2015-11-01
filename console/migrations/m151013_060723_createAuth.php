<?php

use console\components\Migration;

class m151013_060723_createAuth extends Migration
{
    public function up()
    {
        $this->createTable('oauth', [
            'id'        => parent::PRIMARY_KEY,
            'user_id'   => parent::INT_FIELD . ' NOT NULL',
            'source'    => 'VARCHAR(255) NOT NULL',
            'source_id' => 'VARCHAR(255) NOT NULL',
        ], parent::TABLE_OPTIONS);

        $this->addForeignKey('fk_oauth_user_id', 'oauth', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_oauth_user_id', 'oauth');
        $this->dropTable('oauth');
    }
}
