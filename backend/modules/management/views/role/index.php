<?php

use yii\grid\GridView;
use yii\grid\DataColumn;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use \yii\helpers\Url;

$this->title = 'Roles management';
?>

<div class="news-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div>&nbsp;</div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class'     => DataColumn::className(),
                'attribute' => 'name',
                'label'     =>  Yii::t('label', 'Role')
            ],
            [
                'class'     => DataColumn::className(),
                'attribute' => 'description',
                'label'     => Yii::t('label', 'Description')
            ],
            [
                'class'  => DataColumn::className(),
                'label'  => Yii::t('label', 'Assignment rules'),
                'format' => ['html'],
                'value'  => function ($data) {
                    return implode('<br>',
                        array_keys(ArrayHelper::map(Yii::$app->authManager->getPermissionsByRole($data->name),
                            'description', 'description')));
                }
            ],
            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'contentOptions' => ['style' => 'min-width: 30px; text-align: center'],
                'buttons'  =>
                    [
                        'update' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                                Url::toRoute(['manage', 'name' => $model->name]), [
                                    'title'     => Yii::t('yii', 'Update'),
                                    'data-pjax' => '0',
                                ]);
                        },
                    ]
            ],
        ]
    ]);
    ?>
</div>