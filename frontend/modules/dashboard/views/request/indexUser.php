<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\components\DatePickerFactory;
use common\models\rubric\Rubric;
use common\models\request\Request;
use common\models\category\Category;
use yii\widgets\Pjax;
use app\assets\DashboardAsset;

DashboardAsset::register($this);

$this->title = 'Мои заявки';

?>

<div class="news-index">
    <legend><?= $this->title; ?></legend>
    <div class="row">
        <div class="col-md-3 radioList">
            <?= Html::radioList('categoryId', (int)$searchModel->categoryId, $categories); ?>
        </div>

        <?php Pjax::begin(['id' => 'requestGrid']); ?>
        <div class="col-md-9">
            <?php
            $title = 'Все категории';
            if (!empty($searchModel->categoryId)) {
                $category = Category::find()->whereId($searchModel->categoryId)->one();
                $title = !empty($category) ? $category->name : 'Категория не найдена';
            }
            ?>

            <legend><?= $title; ?></legend>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel'  => $searchModel,
                'columns'      => [
                    'id',
                    [
                        'attribute' => 'rubric_id',
                        'filter'    => Rubric::getList($searchModel->categoryId),
                        'value'     => function ($data) {
                            return !empty($data->rubric) ? $data->rubric->name : null;
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'filter'    => Request::$statusList,
                        'value'     => function ($data) {
                            return Request::$statusList[$data->status];
                        }
                    ],
                    [
                        'attribute' => 'date_create',
                        'format'    => 'date',
                        'filter'    => DatePickerFactory::getInput($searchModel, 'date_create')
                    ],
                    [
                        'class'    => 'yii\grid\ActionColumn',
                        'template' => '{view}'
                    ],
                ],
            ]);
            ?>
        </div>
        <?php Pjax::end(); ?>
    </div>
</div>