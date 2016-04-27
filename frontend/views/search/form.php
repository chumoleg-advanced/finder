<?php

/* @var $this yii\web\View */
/* @var $rubric common\models\rubric\Rubric */

use \yii\helpers\Url;
use \yii\helpers\Html;
use frontend\assets\FormCarSearchAsset;

FormCarSearchAsset::register($this);

$this->title = $rubric->name . '. Создание заявки';
?>

<div class="container mainCont">
    <div class="row">
        <div class="col-md-12">
            <?php
            if (!isset($hideBackLink)) {
                echo Html::a('Тут были хлебные крошки...',
                    Url::toRoute(['/search/category', 'id' => $rubric->category]), ['class' => 'autoRepair']);
            }
            ?>
        </div>
    </div>

    <?= $this->render($formView, ['model' => $formModel, 'rubric' => $rubric]); ?>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12">
            <?php
            if (!isset($hideBackLink)) {
                echo Html::a('Вернуться в услуги автосервиса',
                    Url::toRoute(['/search/category', 'id' => $rubric->category]), ['class' => 'autoRepair']);
            }
            ?>
        </div>
    </div>

    <?= Html::hiddenInput('rubricCssClass', $rubric->css_class_background); ?>
</div>