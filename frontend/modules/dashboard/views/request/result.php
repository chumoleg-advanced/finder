<?php
$this->title = 'Заявка создана успешно!';
?>

<div class="news-index">
    <legend><?= $this->title; ?></legend>

    <?= \yii\helpers\Html::a('Перейти к списку', \yii\helpers\Url::toRoute('request/index'),
        ['class' => 'btn btn-default']); ?>
</div>