<?php
use \yii\helpers\Html;
?>

<div class="row">
    <div class="col-md-12 formDiv">
        <div class="col-md-12"><?= Html::textInput('description'); ?></div>
    </div>

    <div class="col-md-12 formDiv">
        <div class="col-md-12">
            <?= Html::dropDownList('points'); ?>
            <?= Html::dropDownList('diameter'); ?>
            <?= Html::dropDownList('width'); ?>
            <?= Html::dropDownList('protrusion'); ?>
            <?= Html::textInput('count'); ?>
        </div>
    </div>

    <div class="col-md-12 formDiv">
        <div class="col-md-6">
            <?= Html::button('Литые'); ?>
            <?= Html::button('Кованные'); ?>
            <?= Html::button('Штампованные'); ?>
        </div>
        <div class="col-md-6">
            <?= Html::button('Новые'); ?>
            <?= Html::button('Б/у'); ?>
        </div>
    </div>

    <div class="col-md-12 formDiv borderDashed">
        <div class="col-md-6">
            Укажите цену<br />
            от <?= Html::textInput('priceFrom'); ?>
            до <?= Html::textInput('priceTo'); ?><br/><br/>

            <?= Html::label('Необходима доставка', 'withMe'); ?>
            <?= Html::checkbox('withMe'); ?><br/>
            <?= Html::textInput('address'); ?><br/>

            <?= Html::label('Рядом со мной', 'withMe'); ?>
            <?= Html::checkbox('withMe'); ?><br/>
            <?= Html::dropDownList('districts'); ?>
        </div>
        <div class="col-md-6"></div>
    </div>

    <div class="col-md-12 formDiv">
        <div class="col-md-12"><?= Html::button('Отправить заявку'); ?></div>
    </div>
</div>