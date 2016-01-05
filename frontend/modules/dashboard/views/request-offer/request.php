<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\components\DatePickerFactory;
use common\models\rubric\Rubric;
use common\models\request\Request;
use common\models\company\Company;
use yii\widgets\Pjax;
use app\assets\DashboardMainAsset;

DashboardMainAsset::register($this);

$this->title = 'Заявки';

?>

<div class="news-index">
    <legend><?= $this->title; ?></legend>

    <?php Pjax::begin(['id' => 'requestGrid']); ?>
    <div class="row">
        <div class="col-md-9">
            <legend><?= $title; ?></legend>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel'  => $searchModel,
                'columns'      => [
                    'id',
                    [
                        'attribute' => 'rubric_id',
                        'filter'    => Rubric::getList($searchModel->categoryId),
                        'value'     => function ($data) {
                            return !empty($data->rubric) ? $data->rubric->name : null;
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'filter'    => Request::$statusListCompany,
                        'value'     => function ($data) {
                            return Request::$statusListCompany[$data->status];
                        }
                    ],
                    [
                        'attribute' => 'date_create',
                        'format'    => 'date',
                        'filter'    => DatePickerFactory::getInput($searchModel, 'date_create')
                    ],
                    [
                        'class'    => 'common\components\ActionColumn',
                        'template' => '{view}'
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>