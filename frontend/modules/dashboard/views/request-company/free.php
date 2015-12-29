<?php

use yii\grid\GridView;
use common\components\DatePickerFactory;
use common\models\rubric\Rubric;
use yii\widgets\Pjax;
use app\assets\DashboardAsset;

DashboardAsset::register($this);

$this->title = 'Заявки для предложений';

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
                    'id',
                    [
                        'attribute' => 'rubric_id',
                        'filter'    => Rubric::getList($searchModel->categoryId),
                        'value'     => function ($data) {
                            return !empty($data->rubric) ? $data->rubric->name : null;
                        }
                    ],
                    [
                        'attribute' => 'date_create',
                        'format'    => 'date',
                        'filter'    => DatePickerFactory::getInput($searchModel, 'date_create')
                    ],
                    [
                        'class'    => 'common\components\ActionColumn',
                        'template' => '{offer}'
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>