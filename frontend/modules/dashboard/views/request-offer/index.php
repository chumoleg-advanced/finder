<?php

/** @var \common\models\request\RequestOfferSearch $searchModel */

use yii\grid\GridView;
use common\components\DatePickerFactory;
use yii\widgets\Pjax;
use app\assets\DashboardMainAsset;
use common\models\request\RequestOffer;
use common\components\ManageButton;

DashboardMainAsset::register($this);

$this->title = 'Заявки от клиентов';

?>

<div class="news-index">
    <legend><?= $this->title; ?></legend>

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
                        'filter'    => RequestOffer::$statusList,
                        'value'     => function ($data) {
                            return RequestOffer::$statusList[$data->status];
                        }
                    ],
                    [
                        'attribute' => 'company_id',
                        'filter'    => $searchModel->getListCompanies(),
                        'value'     => function ($data) {
                            return !empty($data->company) ? $data->company->legal_name : null;
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
                        'headerOptions' => ['width' => '50'],
                        'value'         => function ($data) {
                            return $data->getStatisticRow();
                        }
                    ],
                    [
                        'class'         => 'common\components\ActionColumn',
                        'template'      => '{offer} {reject}',
                        'headerOptions' => ['width' => '90'],
                        'buttons'       => [
                            'reject' => function ($url, $model) {
                                return $model->status == RequestOffer::STATUS_NEW
                                    ? ManageButton::reject($url) : null;
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