<?php

use yii\grid\GridView;
use yii\helpers\Html;
use common\components\DatePickerFactory;
use common\components\ManageButton;
use common\models\company\Company;

/* @var $this yii\web\View */
/* @var $searchModel common\models\company\CompanySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Управление компаниями';
?>
<div class="company-index">
    <legend><?= Html::encode($this->title) ?></legend>
    <div>&nbsp;</div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            'id',
            [
                'attribute' => 'user_id',
                'filter'    => $searchModel->getUserList(),
                'value'     => function ($data) {
                    return !empty($data->user) ? $data->user->email : null;
                }
            ],
            'legal_name',
            'inn',
            [
                'attribute' => 'status',
                'filter'    => Company::$statusList,
                'value'     => function ($data) {
                    return Company::$statusList[$data->status];
                }
            ],
            [
                'attribute' => 'date_create',
                'format'    => 'date',
                'filter'    => DatePickerFactory::getInput($searchModel, 'date_create')
            ],
            [
                'class'         => 'common\components\ActionColumn',
                'template'      => '{update} {accept} {reject} {reset}',
                'headerOptions' => ['width' => '127'],
                'buttons'       => [
                    'reject' => function ($url, $model) {
                        return $model->status == Company::STATUS_ON_MODERATE ? ManageButton::reject($url) : null;
                    },
                    'accept' => function ($url, $model) {
                        return $model->status == Company::STATUS_ON_MODERATE ? ManageButton::accept($url) : null;
                    },
                    'reset'  => function ($url, $model) {
                        return $model->status != Company::STATUS_ON_MODERATE ? ManageButton::reset($url) : null;
                    },
                ],
            ],
        ],
    ]);
    ?>
</div>
