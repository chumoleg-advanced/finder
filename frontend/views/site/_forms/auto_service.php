<?php
use \yii\helpers\Html;
?>

<div class="row">
    <div class="col-md-12 formDiv borderDashed">
        <div class="col-md-2">Мне нужно:</div>
        <div class="col-md-5"><?= Html::textInput('description'); ?></div>
        <div class="col-md-5"><?= Html::textInput('comment'); ?></div>
    </div>

    <div class="col-md-12 formDiv">
        <div class="col-md-2"></div>
        <div class="col-md-10">
            <?= Html::button('Добавить еще одну работу'); ?>
        </div>
    </div>

    <div class="col-md-12 formDiv">
        <div class="col-md-2">Для:</div>
        <div class="col-md-10">
            <?= Html::textInput('carFirm'); ?><br />
            <?= Html::textInput('carModel'); ?>
            <?= Html::textInput('carBody'); ?>
        </div>
    </div>

    <div class="col-md-12 formDiv borderDashed">
        <div class="col-md-2"></div>
        <div class="col-md-5">
            <?= Html::textInput('vinNumber'); ?><br />
            <?= Html::textInput('yearRelease'); ?><br />
            <?= Html::textInput('drive'); ?><br />
            <?= Html::textInput('transmission'); ?>
        </div>
        <div class="col-md-5">
            <?= Html::label('Рядом со мной', 'withMe'); ?>
            <?= Html::checkbox('withMe'); ?><br />
            <?= Html::dropDownList('districts'); ?>
        </div>
    </div>

    <div class="col-md-12 formDiv">
        <div class="col-md-2"></div>
        <div class="col-md-10"><?= Html::button('Отправить заявку'); ?></div>
    </div>
</div>