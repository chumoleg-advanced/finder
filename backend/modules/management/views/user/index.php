<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use common\components\DatePickerFactory;

/* @var $this yii\web\View */
/* @var $searchModel common\models\user\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('title', 'Users management');
?>
<div class="user-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div>&nbsp;</div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            'id',
            'username',
            'email:email',
            'status',
            [
                'attribute' => 'created_at',
                'format'    => 'date',
                'filter'    => DatePickerFactory::getInput($searchModel, 'created_at')
            ],
            [
                'attribute' => 'updated_at',
                'format'    => 'date',
                'filter'    => DatePickerFactory::getInput($searchModel, 'updated_at')
            ],
            [
                'class'          => 'yii\grid\ActionColumn',
                'template'       => '{view}&nbsp;&nbsp;{update}&nbsp;&nbsp;{permit}',
                'contentOptions' => ['style' => 'min-width: 75px; text-align: center'],
                'buttons'        => [
                    'permit' => function ($url, $model) {
                        if (!Yii::$app->user->can('userRoleManage')) {
                            return null;
                        }

                        return Html::a('<span class="glyphicon glyphicon-wrench"></span>',
                            Url::toRoute(['/management/permission/view', 'id' => $model->id]), [
                                'title' => Yii::t('label', 'Change user role')
                            ]
                        );
                    },
                ]
            ],
        ],
    ]);
    ?>
</div>
