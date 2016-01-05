<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\request\Request */

$this->title = 'Заявка №' . $model->id;
?>
<div class="request-update">
    <div>
        <legend><?= $this->title; ?></legend>

        <?= Html::a('Вернуться к списку', \yii\helpers\Url::toRoute('request/index'),
            ['class' => 'btn btn-default']); ?>
        <div>&nbsp;</div>

        <?php
        echo \yii\widgets\DetailView::widget([
            'model'      => $model,
            'attributes' => [
                'id',
                [
                    'attribute' => 'user_id',
                    'value'     => !empty($model->user) ? $model->user->email : null
                ],
                [
                    'attribute' => 'categoryId',
                    'value'     => !empty($model->rubric) ? $model->rubric->category->name : null
                ],
                [
                    'attribute' => 'rubric_id',
                    'value'     => !empty($model->rubric) ? $model->rubric->name : null
                ],
                'description',
                'comment',
                [
                    'attribute' => 'date_create',
                    'format'    => 'date',
                ],
            ]
        ]);
        ?>
    </div>
</div>
