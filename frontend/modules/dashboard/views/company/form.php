<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\modules\dashboard\forms\CompanyForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Создание организации';
?>

<div class="">
    <legend><?= Html::encode($this->title); ?></legend>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'company-form']); ?>

            <?= $form->field($model, 'name'); ?>
            <?= $form->field($model, 'inn'); ?>

            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
