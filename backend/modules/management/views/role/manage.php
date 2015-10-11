<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $role yii\rbac\Role */

$this->title = Yii::t('label', 'Assignment rules') . ' ' . $role->name;
?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div>&nbsp;</div>

    <div class="links-form">
        <?php $form = ActiveForm::begin(); ?>

        <div class="form-group">
            <?= Html::checkboxList('permissions', $rolePermit, $permissions, ['separator' => '<br>']); ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('button', 'Update'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
