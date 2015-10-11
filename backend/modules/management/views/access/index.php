<?php

use yii\grid\GridView;
use yii\grid\DataColumn;
use yii\helpers\Html;

$this->title = Yii::t('title', 'Access rules');
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
                'label'     => Yii::t('label', 'Rule')
            ],
            [
                'class'     => DataColumn::className(),
                'attribute' => 'description',
                'label'     => Yii::t('label', 'Description')
            ],
        ]
    ]);
    ?>
</div>