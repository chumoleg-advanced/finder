<?php

/* @var $this yii\web\View */

$this->title = Yii::t('title', 'Result');
?>

<div class="site-index">
    <div class="jumbotron" style="margin-top: 20vh;">
        <p class="lead">Ваш запрос успешно зарегистрирован!</p>
        <?php echo \yii\helpers\Html::a('На главную', '/site/index'); ?>
    </div>
</div>
