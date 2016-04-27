<?php

namespace common\helpers;

use common\models\rubric\Rubric;
use yii\helpers\ArrayHelper;

class CategoryHelper
{
    const CATEGORY_SERVICE = 1;
    const CATEGORY_PARTS = 2;

    /**
     * @return array
     */
    public static function getList()
    {
        return [
            self::CATEGORY_SERVICE => [
                'name'        => 'Автосервис',
                'description' => 'Любые услуги по автосервису: от удаления вмятин до замены ходовой части.',
                'image'       => '/img/icons_main/main1.svg',
                'rubricList'  => Rubric::getList(self::CATEGORY_SERVICE)
            ],

            self::CATEGORY_PARTS => [
                'name'        => 'Автозапчасти/Автотовары',
                'description' => 'Вы найдёте нужное: всё от запчастей до дисков и шин.',
                'image'       => '/img/icons_main/main2.svg',
                'rubricList'  => Rubric::getList(self::CATEGORY_PARTS)
            ]
        ];
    }

    /**
     * @param array $categories
     *
     * @return array
     */
    public static function getListByIds(array $categories)
    {
        $array = [];
        foreach (self::getList() as $id => $item) {
            if (isset($categories[$id])) {
                $array[$id] = ArrayHelper::getValue($item, 'name');
            }
        }

        return $array;
    }

    /**
     * @param int $category
     *
     * @return string|null
     */
    public static function getNameByCategory($category)
    {
        if (empty($category)){
            return null;
        }

        return ArrayHelper::getValue(self::getList(), $category . '.name');
    }
}