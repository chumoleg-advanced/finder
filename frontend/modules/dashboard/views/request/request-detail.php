<?php

/** @var \common\models\request\Request $model */

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