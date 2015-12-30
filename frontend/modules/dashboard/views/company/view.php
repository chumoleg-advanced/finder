<?php
$this->title = 'Кломпания ' . $model->legal_name;
?>

<div class="news-index">
    <legend><?= $this->title; ?></legend>

    <?php
    echo \yii\widgets\DetailView::widget([
        'model'      => $model,
        'attributes' => [
            [
                'label'   => 'Статус',
                'format'=>'raw',
                'value'   => \yii\helpers\Html::tag('div', \common\models\company\Company::$statusList[$model->status],
                    ['class' => 'text-bold text-error']),
                'options' => ['class' => 'bold']
            ],
            'legal_name',
            'actual_name',
            'form',
            'inn',
            'ogrn'
        ]
    ]);
    ?>
</div>