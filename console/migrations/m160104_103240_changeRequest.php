<?php

use console\components\Migration;
use yii\base\Exception;

class m160104_103240_changeRequest extends Migration
{
    public function up()
    {
        try {
            $this->dropForeignKey('fk_request_performer_company_id', 'request');
            $this->dropColumn('request', 'performer_company_id');
        } catch (Exception $e) {
        }

        try {
            $this->dropForeignKey('fk_request_request_offer_id', 'request');
            $this->dropColumn('request', 'request_offer_id');
        } catch (Exception $e) {
        }

        $this->addColumn('request', 'description', 'TEXT AFTER rubric_id');
        $this->addColumn('request', 'comment', 'TEXT AFTER description');

        try {
            $this->dropForeignKey('fk_request_position_request_id', 'request_position');
            $this->dropTable('request_position');

        } catch (Exception $e) {
        }

        $this->addColumn('request_offer', 'user_id', self::INT_FIELD . ' AFTER request_id');
        $this->addForeignKey('fk_request_offer_user_id', 'request_offer',
            'user_id', 'user', 'id', 'CASCADE', 'CASCADE');

        $this->alterColumn('request_offer', 'company_id', self::INT_FIELD . ' DEFAULT NULL');

        $this->addColumn('request', 'count_view', self::INT_FIELD . ' DEFAULT 0 AFTER user_id');
    }

    public function down()
    {
        $this->dropColumn('request', 'description');
        $this->dropColumn('request', 'comment');

        $this->dropForeignKey('fk_request_offer_user_id', 'request_offer');
        $this->dropColumn('request_offer', 'user_id');

        $this->dropColumn('request', 'count_view');
    }
}
