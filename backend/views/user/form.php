<?php

use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\user\User */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('title', 'User data') . ': ' . $model->email;
?>
<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'email')->textInput(); ?>
<?= $form->field($model, 'phone')->textInput(); ?>
<?= $form->field($model, 'fio')->textInput(); ?>
<?= $form->field($model, 'birthday')->textInput(); ?>
<?= $form->field($model, 'status')->dropDownList([]); ?>

<div class="form-group"><?= common\helpers\ButtonHelper::getSubmitButton($model); ?></div>
<?php ActiveForm::end(); ?>
