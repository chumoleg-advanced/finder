<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\components\DatePickerFactory;
use common\models\rubric\Rubric;
use common\models\request\Request;
use common\models\company\Company;
use yii\widgets\Pjax;
use app\assets\DashboardAsset;

DashboardAsset::register($this);

$this->title = 'Заявки';

?>

<div class="news-index">
    <legend><?= $this->title; ?></legend>

    <?php Pjax::begin(['id' => 'requestGrid']); ?>
    <div class="row">
        <div class="col-md-3 radioList">
            <?= Html::radioList('companyId', (int)$searchModel->performer_company_id, $companies); ?>
        </div>

        <div class="col-md-9">
            <?php
            $title = 'Все компании';
            if (!empty($searchModel->performer_company_id)) {
                $company = Company::find()->whereId($searchModel->performer_company_id)->one();
                $title = !empty($company) ? $company->legal_name : 'Компания не найдена';
            }
            ?>

            <legend><?= $title; ?></legend>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel'  => $searchModel,
                'columns'      => [
                    'id',
                    [
                        'attribute' => 'performer_company_id',
                        'filter'    => Company::getListByUser(),
                        'visible'   => empty($searchModel->performer_company_id),
                        'value'     => function ($data) {
                            return !empty($data->performerCompany) ? $data->performerCompany->legal_name : null;
                        }
                    ],
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