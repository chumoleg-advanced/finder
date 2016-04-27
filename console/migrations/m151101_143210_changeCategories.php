<?php

use console\components\Migration;

class m151101_143210_changeCategories extends Migration
{
    public function up()
    {
        $date = date('Y-m-d H:i:s');

        $this->execute('SET foreign_key_checks = 0;');
        $this->truncateTable('rubric');
        $this->truncateTable('category');
        $this->execute('SET foreign_key_checks = 1;');

        $this->insert('category', [
            'name'        => 'Автосервис',
            'date_create' => $date
        ]);
        $this->insert('category', [
            'name'        => 'Автозапчасти / Автотовары',
            'date_create' => $date
        ]);

        $this->addColumn('rubric', 'rubric_form', 'TINYINT NOT NULL AFTER category_id');

        $rubricsService = [
            'Авторемонт и техобслуживание (СТО)' => 5,
            'Ремонт дисков'                      => 6,
            'Кузовной ремонт / малярные работы'  => 7,
            'Установка / ремонт автостёкол'      => 5,
            'Ремонт автоэлектрики'               => 5,
            'Ремонт ходовой части автомобиля'    => 5,
            'Ремонт дизельных двигателей'        => 5,
            'Ремонт бензиновых двигателей'       => 5
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
        $this->dropColumn('rubric', 'rubric_form');
    }

    /**
     * @param [] $rubricsData
     * @param int $category
     */
    private function _insertRubrics($rubricsData, $category)
    {
        $date = date('Y-m-d H:i:s');
        foreach ($rubricsData as $name => $formId) {
            $this->insert('rubric', [
                'category_id'    => $category,
                'name'           => $name,
                'rubric_form' => $formId,
                'date_create'    => $date
            ]);
        }
    }
}
