<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\request\Request */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Заявка №' . $model->id;
?>
<div class="request-update">
    <h1><?= Html::encode($this->title); ?></h1>

    <div class="request-form">
        <?php $form = ActiveForm::begin(); ?>

        <div class="form-group">
            <?= common\helpers\ButtonHelper::getSubmitButton($model); ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
