<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\company\Company */
/* @var $form yii\widgets\ActiveForm */

$this->title = $model->legal_name;
?>
<div class="company-update">
    <legend><?= Html::encode($this->title); ?></legend>

    <div class="company-form">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'legal_name')->textInput() ?>

        <div class="form-group">
            <?= common\helpers\ButtonHelper::getSubmitButton($model); ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
