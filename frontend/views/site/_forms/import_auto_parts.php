<?php
use \yii\helpers\Html;

?>

<div class="row">
    <div class="col-md-12 formDiv borderDashed">
        <div class="col-md-12">
            <div class="col-md-2">Я ищу:</div>
            <div class="col-md-5"><?= Html::textInput('description'); ?></div>
            <div class="col-md-5"><?= Html::textInput('comment'); ?></div>
        </div>

        <div class="col-md-12">
            <div class="col-md-2"></div>
            <div class="col-md-5">
                <?= Html::button('Новая'); ?>
                <?= Html::button('Контракт'); ?>
                <?= Html::button('Б/у'); ?>
            </div>
            <div class="col-md-5">
                <?= Html::button('Оригинал'); ?>
                <?= Html::button('Аналог'); ?>
                <?= Html::button('Любая'); ?>
            </div>
        </div>
    </div>

    <div class="col-md-12 formDiv">
        <div class="col-md-2"></div>
        <div class="col-md-10">
            <?= Html::button('Добавить еще одну запчасть'); ?>
        </div>
    </div>

    <div class="col-md-12 formDiv">
        <div class="col-md-2">Для:</div>
        <div class="col-md-10">
            <?= Html::textInput('carFirm'); ?><br/>
            <?= Html::textInput('carModel'); ?>
            <?= Html::textInput('carBody'); ?><br/>
        </div>
    </div>

    <div class="col-md-12 formDiv borderDashed">
        <div class="col-md-2"></div>
        <div class="col-md-5">
            <?= Html::textInput('vinNumber'); ?><br/>

            <?= Html::label('Необходима доставка', 'withMe'); ?>
            <?= Html::checkbox('withMe'); ?><br/>
            <?= Html::textInput('address'); ?><br/>

            <?= Html::label('Рядом со мной', 'withMe'); ?>
            <?= Html::checkbox('withMe'); ?><br/>
            <?= Html::dropDownList('districts'); ?>
        </div>
        <div class="col-md-5"></div>
    </div>

    <div class="col-md-12 formDiv">
        <div class="col-md-2"></div>
        <div class="col-md-10"><?= Html::button('Отправить заявку'); ?></div>
    </div>
</div>