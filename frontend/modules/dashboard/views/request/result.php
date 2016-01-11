<?php
$this->title = 'Заявка создана успешно!';
?>

<?= \yii\helpers\Html::a('Перейти к списку', \yii\helpers\Url::toRoute('request/index'),
    ['class' => 'btn btn-default']); ?>