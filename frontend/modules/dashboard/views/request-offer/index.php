<?php

/** @var \common\models\requestOffer\MainRequestOfferSearch $searchModel */
use yii\helpers\Html;
use yii\grid\GridView;
use common\components\DatePickerFactory;
use yii\widgets\Pjax;
use common\models\requestOffer\MainRequestOffer;
use common\components\ManageButton;

$this->title = 'Заявки от клиентов';
?>
<div class="container mainCont dashboard">
    <div class="dynamicFormRow">
        <div class="col-md-12 col-sm-12 col-xs-12 myRequest">
            <h1><?= Html::encode($this->title); ?></h1>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <?php Pjax::begin(['id' => 'requestGrid']); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel'  => $searchModel,
                'tableOptions' => ['class' => 'table table-hover'],
                'layout'     => '<div class="table-scrollable">{items}</div><div class="row">{pager}</div>',
                'columns'      => [
                    'request_id',
                    [
                        'attribute' => 'status',
                        'filter'    => MainRequestOffer::$statusList,
                        'value'     => function ($data) {
                            return MainRequestOffer::$statusList[$data->status];
                        }
                    ],
                    [
                        'attribute' => 'category',
                        'filter'    => $searchModel->getListCategories(),
                        'value'     => function ($data) {
                            return !empty($data->request)
                                ? \common\helpers\CategoryHelper::getNameByCategory($data->request->category) : null;
                        }
                    ],
                    [
                        'attribute' => 'rubricId',
                        'filter'    => $searchModel->getListRubrics(),
                        'value'     => function ($data) {
                            return !empty($data->request) ? $data->request->rubric->name : null;
                        }
                    ],
                    [
                        'attribute' => 'description',
                        'value'     => function ($data) {
                            return $data->request->description;
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
                        'headerOptions' => ['width' => '150'],
                        'value'         => function ($data) {
                            return $data->getStatisticRow();
                        }
                    ],
                    [
                        'class'         => 'common\components\ActionColumn',
                        'template'      => '{offer} {close} {reset}',
                        'headerOptions' => ['width' => '90'],
                        'buttons'       => [
                            'offer' => function ($url, $model, $key) {
                                $options = [
                                    'class'      => 'tBtn',
                                    'title'      => Yii::t('yii', 'offer'),
                                    'aria-label' => Yii::t('yii', 'offer'),
                                ];
                                return Html::a('<i class="fa fa-eye"></i>Посмотреть', $url, $options);
                            },

                            'close' => function ($url, $model) {
                                if( $model->status == MainRequestOffer::STATUS_CLOSED) {
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
                                if( $model->status != MainRequestOffer::STATUS_CLOSED) {
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
            ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>