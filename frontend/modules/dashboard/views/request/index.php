<?php

/** @var \common\models\request\RequestSearch $searchModel */
use yii\helpers\Html;
use yii\grid\GridView;
use common\components\DatePickerFactory;
use common\models\request\Request;
use yii\widgets\Pjax;

use common\components\ManageButton;

$this->title = 'Мои заявки';
?>
<div class="container mainCont dashboard">
    <div class="dynamicFormRow">
        <div class="col-md-12 col-sm-12 col-xs-12 myRequest">
            <h1><?= Html::encode($this->title); ?></h1>
        </div>
        <div class="dynamicFormRowBody">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <?php
                Pjax::begin(['id' => 'requestGrid']);

                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel'  => $searchModel,
                    'tableOptions' => ['class' => 'PStable table table-hover'],
                    'layout'     => '<div class="table-scrollable">{items}</div><div class="row">{pager}</div>',
                    'columns'      => [
                        [
                            'attribute' => 'id',
                            'headerOptions' => ['width' => '100'],
                        ],
                        [
                            'attribute' => 'category',
                            'headerOptions' => ['width' => '150'],
                            'filter'    => $searchModel->getCategoryList(),
                            'value'     => function ($data) {
                                return \common\helpers\CategoryHelper::getNameByCategory($data->category);
                            }
                        ],
                        [
                            'attribute' => 'rubric_id',
                            'headerOptions' => ['width' => '170'],
                            'filter'    => $searchModel->getRubricList(),
                            'value'     => function ($data) {
                                return !empty($data->rubric) ? $data->rubric->name : null;
                            }
                        ],
                        'description',
                        [
                            'attribute' => 'status',
                            'headerOptions' => ['width' => '130'],
                            'filter'    => Request::$statusList,
                            'value'     => function ($data) {
                                return Request::$statusList[$data->status];
                            }
                        ],
                        [
                            'attribute' => 'date_create',
                            'headerOptions' => ['width' => '140'],
                            'format'    => 'date',
                            'filter'    => DatePickerFactory::getInput($searchModel, 'date_create')
                        ],
                        [
                            'label'         => '',
                            'filter'        => false,
                            'format'        => 'raw',
                            'headerOptions' => ['width' => '140'],
                            'value'         => function ($data) {
                                return $data->getStatisticRow();
                            }
                        ],
                        [
                            'class'         => 'common\components\ActionColumn',
                            'template'      => '{view} {close} {reset}',
                            'headerOptions' => ['width' => '90'],
                            'buttons'       => [
                                'view' => function ($url, $model, $key) {
                                    $options = [
                                        'class'      => 'tBtn',
                                        'title'      => Yii::t('yii', 'View'),
                                        'aria-label' => Yii::t('yii', 'View'),
                                    ];
                                    return Html::a('<i class="fa fa-eye"></i>Посмотреть', $url, $options);
                                },

                                'close' => function ($url, $model) {
                                    if( $model->status == Request::STATUS_CLOSED) {
                                        return null;
                                    }
                                    $options = [
                                        'class'      => 'tBtn',
                                        'title'      => Yii::t('yii', 'close'),
                                        'aria-label' => Yii::t('yii', 'close'),
                                    ];
                                    return Html::a('<i class="fa fa-lock"></i>Закрыть', $url, $options);

                                },

                                'reset' => function ($url, $model) {
                                    if( $model->status != Request::STATUS_CLOSED) {
                                        return null;
                                    }
                                    $options = [
                                        'class'      => 'tBtn',
                                        'title'      => Yii::t('yii', 'reset'),
                                        'aria-label' => Yii::t('yii', 'reset'),
                                    ];
                                    return Html::a('<i class="fa fa-repeat"></i>Возобновить', $url, $options);
                                },
                            ],
                        ],
                    ],
                ]);

                Pjax::end();
                ?>
            </div>
        </div>
    </div>
</div>