<?php
use \kartik\helpers\Html;
?>

<div class="form-group">
    <div class="col-md-offset-2 col-md-10 col-sm-12 col-xs-12">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <?= Html::submitButton('Отправить заявку', ['class' => 'btn btn-primary']); ?>
            <?= Html::resetButton('Сбросить', ['class' => 'btn btn-default']); ?>
        </div>
    </div>
</div>