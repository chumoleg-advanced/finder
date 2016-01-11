<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use common\components\DatePickerFactory;
use common\models\user\User;
use common\components\ManageButton;

/* @var $this yii\web\View */
/* @var $searchModel common\models\user\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Управление пользователями';
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        'id',
        'email',
        [
            'attribute' => 'status',
            'filter'    => User::$statusList,
            'value'     => function ($data) {
                return User::$statusList[$data->status];
            }
        ],
        [
            'attribute' => 'created_at',
            'format'    => 'date',
            'filter'    => DatePickerFactory::getInput($searchModel, 'created_at')
        ],
        [
            'class'         => 'common\components\ActionColumn',
            'template'      => '{update} {permission} {reset} {reject}',
            'headerOptions' => ['width' => '127'],
            'buttons'       => [
                'reject'     => function ($url, $model) {
                    return $model->status == User::STATUS_ACTIVE ? ManageButton::reject($url) : null;
                },
                'reset'      => function ($url, $model) {
                    return $model->status != User::STATUS_ACTIVE ? ManageButton::reset($url) : null;
                },
                'permission' => function ($url, $model) {
                    if (!Yii::$app->user->can('userRoleManage')) {
                        return null;
                    }

                    $url = Url::toRoute(['/management/permission/view', 'id' => $model->id]);

                    return Html::a('<span class="glyphicon glyphicon-wrench"></span>', $url, [
                        'title'     => 'Настройка роли',
                        'data-pjax' => '0',
                        'class'     => 'btn btn-default btn-sm',
                    ]);
                },
            ]
        ]
    ],
]);