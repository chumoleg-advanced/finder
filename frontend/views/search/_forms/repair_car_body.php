<?php

use common\models\car\CarFirm;
use frontend\components\SearchFormGenerator;

/** @var $model frontend\forms\request\AutoServiceForm */
/** @var $rubric common\models\rubric\Rubric */
/** @var $this \yii\web\View */

$form = SearchFormGenerator::getFormFiles($rubric->id);
?>

<div class="carSelect">
  <div class="rw1170">
    <?= $this->render('_parts/_carSelect',
        ['form' => $form, 'model' => $model, 'carFirms' => CarFirm::getList()]); ?>
    <div class="clearfix"></div>
    <div class="collapse " id="additionCarData">
      <?= $this->render('_parts/_additionCarData', ['form' => $form, 'model' => $model]); ?>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'color')->textInput(
                ['class' => 'form-control', 'placeholder' => 'Цвет']); ?>
        </div>
    </div>
    <?= $this->render('_parts/_additionOptionsButton'); ?>
    <div class="clearfix"></div>
  </div>
</div>

<div class="clearfix"></div>

<?= $this->render('_parts/_partOrServiceRow', ['form' => $form, 'model' => $model]); ?>

<div class="row carBg">
    <?= $this->render('_parts/_buttons', ['buttonText' => 'Добавить заявку']); ?>
</div>

<?php $form->end(); ?>