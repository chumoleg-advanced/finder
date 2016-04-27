<?php

use console\components\Migration;

class m160427_045246_removeCategoriesAndRubrics extends Migration
{
    public function up()
    {
        try {
            $this->addColumn('request', 'category', 'TINYINT(3) UNSIGNED');
            $this->execute('UPDATE request t SET t.category = (SELECT category_id FROM rubric WHERE id = t.rubric_id)');

            $this->dropForeignKey('fk_rubric_category_id', 'rubric');
            $this->dropTable('category');

            $this->renameColumn('rubric', 'category_id', 'category');

        } catch (\yii\base\Exception $e){
        }

        try {
            $this->addColumn('rubric', 'image', 'VARCHAR(300) DEFAULT NULL AFTER name');
        } catch (\yii\base\Exception $e){
        }

        try {
            $this->addColumn('rubric', 'css_class_background', 'VARCHAR(100) DEFAULT NULL AFTER name');
        } catch (\yii\base\Exception $e){
        }
    }

    public function down()
    {
        $this->dropColumn('rubric', 'image');
        $this->dropColumn('rubric', 'css_class_background');
    }
}
