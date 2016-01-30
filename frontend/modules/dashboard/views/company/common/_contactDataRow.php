<?php
use common\models\company\CompanyContactData;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

/** @var \common\models\company\CompanyContactData $model */

?>

<div class="row item">
    <?= isset($model->id) ? Html::activeHiddenInput($model, '[' . $k . ']id') : null; ?>

    <div class="col-md-4 col-sm-4 col-xs-12">
        <?= $form->field($model, '[' . $k . ']type', [
            'template' => "{input}\n{hint}\n{error}"
        ])->dropDownList(CompanyContactData::getGroupedTypeList(), ['class' => 'typeContactData']); ?>
    </div>

    <div class="col-md-6 col-sm-6 col-xs-12">
        <?= $form->field($model, '[' . $k . ']data', ['template' => "{input}\n{hint}\n{error}"])
            ->textInput(['class' => 'maskedInput']); ?>
    </div>

    <div class="col-md-1 col-sm-1 col-xs-6 text-right">
        <a class="btn btn-default remove-item">
            <i class="glyphicon glyphicon-minus"></i>
        </a>
    </div>
</div>