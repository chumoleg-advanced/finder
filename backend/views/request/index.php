<?php

use yii\grid\GridView;
use yii\helpers\Html;
use common\components\DatePickerFactory;
use common\components\ManageButton;
use common\models\request\Request;
use common\models\category\Category;
use common\models\rubric\Rubric;

/* @var $this yii\web\View */
/* @var $searchModel common\models\request\RequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Управление заявками';
?>
<div class="user-index">
    <legend><?= Html::encode($this->title) ?></legend>

    <div>&nbsp;</div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            'id',
            [
                'attribute' => 'user_id',
                'filter'    => $searchModel->getUserList(),
                'value'     => function ($data) {
                    return !empty($data->user) ? $data->user->email : null;
                }
            ],
            [
                'attribute' => 'categoryId',
                'filter'    => Category::getList(true),
                'value'     => function ($data) {
                    return !empty($data->rubric) ? $data->rubric->category->name : null;
                }
            ],
            [
                'attribute' => 'rubric_id',
                'filter'    => Rubric::getList($searchModel->categoryId),
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
                'class'         => 'common\components\ActionColumn',
                'template'      => '{update} {accept} {reject}',
                'headerOptions' => ['width' => '127'],
                'buttons'       => [
                    'reject' => function ($url, $model) {
                        return $model->status == Request::STATUS_NEW ? ManageButton::reject($url) : null;
                    },
                    'accept' => function ($url, $model) {
                        return $model->status == Request::STATUS_NEW ? ManageButton::accept($url) : null;
                    },
//                    'reset'  => function ($url, $model) {
//                        return $model->status == Request::STATUS_CLOSED ? ManageButton::reset($url) : null;
//                    },
                ],
            ],
        ],
    ]);
    ?>
</div>
