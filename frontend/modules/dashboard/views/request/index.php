<?php

/** @var \common\models\request\RequestSearch $searchModel */

use yii\grid\GridView;
use common\components\DatePickerFactory;
use common\models\request\Request;
use yii\widgets\Pjax;

use common\components\ManageButton;

$this->title = 'Мои заявки';
?>
<div class="container layout">
<?php
Pjax::begin(['id' => 'requestGrid']);

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        'id',
        [
            'attribute' => 'category',
            'filter'    => $searchModel->getCategoryList(),
            'value'     => function ($data) {
                return \common\helpers\CategoryHelper::getNameByCategory($data->category);
            }
        ],
        [
            'attribute' => 'rubric_id',
            'filter'    => $searchModel->getRubricList(),
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

Pjax::end();
?>
</div>