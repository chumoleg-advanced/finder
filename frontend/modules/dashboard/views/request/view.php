<?php
$this->title = 'Заявка #' . $model->id;
?>

<div class="news-index">
    <legend><?= $this->title; ?></legend>
    <?= \yii\helpers\Html::a('Вернуться к списку', \yii\helpers\Url::to('/dashboard/request/index'),
        ['class' => 'btn btn-default']); ?>
</div>