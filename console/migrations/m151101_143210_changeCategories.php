<?php

use console\components\Migration;

class m151101_143210_changeCategories extends Migration
{
    public function up()
    {
        $date = date('Y-m-d H:i:s');

        $this->createTable('rubric_form', [
            'id'          => parent::PRIMARY_KEY,
            'name_view'   => 'VARCHAR(50) NOT NULL',
            'date_create' => parent::DATE_FIELD,
        ], parent::TABLE_OPTIONS);

        $this->execute('SET foreign_key_checks = 0;');
        $this->truncateTable('rubric');
        $this->truncateTable('category');
        $this->execute('SET foreign_key_checks = 1;');

        $this->insert('category', ['name' => 'Автосервис']);
        $this->insert('category', ['name' => 'Автозапчасти / Автотовары']);

        $this->addColumn('rubric', 'rubric_form_id', self::INT_FIELD . ' NOT NULL AFTER category_id');
        $this->addForeignKey('fk_rubric_rubric_form_id', 'rubric', 'rubric_form_id',
            'rubric_form', 'id', 'RESTRICT', 'CASCADE');

        $forms = [
            1 => 'import_auto_parts',
            2 => 'russian_auto_parts',
            3 => 'tires',
            4 => 'tires_freight',
            5 => 'auto_service',
            6 => 'repair_discs',
            7 => 'repair_car_body'
        ];

        foreach ($forms as $name) {
            $this->insert('rubric_form', [
                'name_view'   => $name,
                'date_create' => $date
            ]);
        }

        $rubricsService = [
            'Авторемонт и техобслуживание(СТО)' => 5,
            'Ремонт дисков'                     => 6,
            'Кузовной ремонт / малярные работы' => 7,
            'Установка / ремонт автостёкол'     => 5,
            'Ремонт автоэлектрики'              => 5,
            'Ремонт ходовой части автомобиля'   => 5,
            'Ремонт дизельных двигателей'       => 5,
            'Ремонт бензиновых двигателей'      => 5
        ];

        $this->_insertRubrics($rubricsService, 1);

        $rubricsProducts = [
            'Новые автозапчасти для иномарок'            => 1,
            'Услуги авторазбора . Б/У автозапчасти'      => 1,
            'Контрактные автозапчасти'                   => 1,
            'Автозапчасти для отечественных автомобилей' => 2,
            'Шины для легковых а\м'                      => 3,
            'Диски для легковых а\м'                     => 4
        ];

        $this->_insertRubrics($rubricsProducts, 2);
    }

    public function down()
    {
        $this->dropForeignKey('fk_rubric_rubric_form_id', 'rubric');
        $this->dropColumn('rubric', 'rubric_form_id');
        $this->dropTable('rubric_form');
    }

    /**
     * @param [] $rubricsData
     * @param int $categoryId
     */
    private function _insertRubrics($rubricsData, $categoryId)
    {
        $date = date('Y-m-d H:i:s');
        foreach ($rubricsData as $name => $formId) {
            $this->insert('rubric', [
                'category_id'    => $categoryId,
                'name'           => $name,
                'rubric_form_id' => $formId,
                'date_create'    => $date
            ]);
        }
    }
}
