<?php

/** @var \common\models\requestOffer\MainRequestOfferSearch $searchModel */

use yii\grid\GridView;
use common\components\DatePickerFactory;
use yii\widgets\Pjax;
use common\models\requestOffer\MainRequestOffer;
use common\components\ManageButton;

$this->title = 'Заявки от клиентов';
?>
<div class="container layout">
<?php Pjax::begin(['id' => 'requestGrid']); ?>
    <div class="row">
        <div class="col-md-12">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel'  => $searchModel,
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
                        'attribute' => 'categoryId',
                        'filter'    => $searchModel->getListCategories(),
                        'value'     => function ($data) {
                            return !empty($data->request) ? $data->request->rubric->category->name : null;
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
                        'headerOptions' => ['width' => '90'],
                        'value'         => function ($data) {
                            return $data->getStatisticRow();
                        }
                    ],
                    [
                        'class'         => 'common\components\ActionColumn',
                        'template'      => '{offer} {close} {reset}',
                        'headerOptions' => ['width' => '90'],
                        'buttons'       => [
                            'close' => function ($url, $model) {
                                return $model->status != MainRequestOffer::STATUS_CLOSED
                                    ? ManageButton::close($url) : null;
                            },
                            'reset' => function ($url, $model) {
                                return $model->status == MainRequestOffer::STATUS_CLOSED
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