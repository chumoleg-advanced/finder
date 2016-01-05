<?php

/** @var \common\models\request\RequestSearch $searchModel */

use yii\helpers\Html;
use yii\grid\GridView;
use common\components\DatePickerFactory;
use common\models\request\Request;
use common\models\category\Category;
use yii\widgets\Pjax;
use app\assets\DashboardMainAsset;
use common\components\ManageButton;

DashboardMainAsset::register($this);

$this->title = 'Мои заявки';

$title = 'Все категории';
if (!empty($searchModel->categoryId)) {
    $category = Category::find()->whereId($searchModel->categoryId)->one();
    $title = !empty($category) ? $category->name : 'Категория не найдена';
}
?>

<div class="news-index">
    <?php Pjax::begin(['id' => 'requestGrid']); ?>
    <legend><?= $this->title . '. ' . $title; ?></legend>

    <div class="row">
        <div class="col-md-3 radioList">
            <?= Html::radioList('categoryId', (int)$searchModel->categoryId, $categories); ?>
        </div>

        <div class="col-md-9">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel'  => $searchModel,
                'columns'      => [
                    'id',
                    [
                        'attribute' => 'categoryId',
                        'filter'    => $searchModel->getCategoryList(),
                        'visible'   => empty($searchModel->categoryId),
                        'value'     => function ($data) {
                            return !empty($data->rubric) ? $data->rubric->category->name : null;
                        }
                    ],
                    [
                        'attribute' => 'rubric_id',
                        'filter'    =>  $searchModel->getRubricList(),
                        'value'     => function ($data) {
                            return !empty($data->rubric) ? $data->rubric->name : null;
                        }
                    ],
                    'description',
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
                        'label'         => '',
                        'filter'        => false,
                        'format'        => 'raw',
                        'headerOptions' => ['width' => '120'],
                        'value'         => function ($data) {
                            return $data->getStatisticRow();
                        }
                    ],
                    [
                        'class'         => 'common\components\ActionColumn',
                        'template'      => '{view} {close} {reset}',
                        'headerOptions' => ['width' => '90'],
                        'buttons'       => [
                            'close' => function ($url, $model) {
                                return $model->status != Request::STATUS_CLOSED
                                    ? ManageButton::close($url) : null;
                            },
                            'reset' => function ($url, $model) {
                                return $model->status == Request::STATUS_CLOSED
                                    ? ManageButton::reset($url) : null;
                            }
                        ],
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>