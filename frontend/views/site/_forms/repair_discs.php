<?php
use \yii\helpers\Html;

?>

<div class="row">
    <div class="col-md-12 formDiv">
        <div class="col-md-2">Мне нужно:</div>
        <div class="col-md-5"><?= Html::textInput('description'); ?></div>
        <div class="col-md-5"><?= Html::textInput('comment'); ?></div>
    </div>

    <div class="col-md-12 formDiv">
        <div class="col-md-2"></div>
        <div class="col-md-10">
            <?= Html::dropDownList('diameter'); ?>
            <?= Html::dropDownList('points'); ?>
            <?= Html::dropDownList('width'); ?>
            <?= Html::textInput('count'); ?>
        </div>
    </div>
    <div class="col-md-12 formDiv">
        <div class="col-md-2"></div>
        <div class="col-md-10">
            <?= Html::button('Литые'); ?>
            <?= Html::button('Кованные'); ?>
            <?= Html::button('Штампованные'); ?>
        </div>
    </div>

    <div class="col-md-12 formDiv">
        <div class="col-md-2"></div>
        <div class="col-md-5 formDiv borderDashed">
            <?= Html::label('Рядом со мной', 'withMe'); ?>
            <?= Html::checkbox('withMe'); ?><br/>
            <?= Html::textInput('districts'); ?>
        </div>
        <div class="col-md-5"></div>
    </div>

    <div class="col-md-12 formDiv">
        <div class="col-md-2"></div>
        <div class="col-md-10"><?= Html::button('Отправить заявку'); ?></div>
    </div>
</div>