<?php

namespace console\components;

class Migration extends \yii\db\Migration
{
    const TABLE_OPTIONS = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
    const PRIMARY_KEY = 'INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY';
    const INT_FIELD = 'INT(10) UNSIGNED';
    const INT_FIELD_NOT_NULL = 'INT(10) UNSIGNED NOT NULL';
    const TIMESTAMP_FIELD = 'TIMESTAMP NULL';
}