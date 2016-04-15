<?php

use common\components\Status;
use common\models\car\CarFirm;
use frontend\components\SearchFormGenerator;

/** @var $model frontend\forms\request\AutoPartForm */
/** @var $rubric common\models\rubric\Rubric */
/** @var $this \yii\web\View */

$form = SearchFormGenerator::getFormFiles($rubric->id);
?>

<div class="row carSelect">
  <div class="rw1170">
    <?= $this->render('_parts/_carSelect', [
        'form'     => $form,
        'model'    => $model,
        'carFirms' => CarFirm::getListByImport(Status::STATUS_ACTIVE)
    ]); ?>
    <div class="clearfix"></div>
    <div class="collapse " id="additionCarData">
      <?= $this->render('_parts/_additionCarData', ['form' => $form, 'model' => $model]); ?>
    </div>
    <?= $this->render('_parts/_additionOptionsButton'); ?>
    <div class="clearfix"></div>
  </div>
</div>

<div class="clearfix"></div>

<?= $this->render('_parts/_partOrServiceRow', [
    'form'        => $form,
    'model'       => $model,
    'buttonText'  => 'Добавить еще одну запчасть',
    'placeholder' => 'Наименование запчасти или ОЕМ номер',
    'parts'       => true
]); ?>

<div class="row carBg">
  <div class="col-md-12 text-center buttonGroup">
    <?= $this->render('_parts/_buttons'); ?>
  </div>
</div>

<?php $form->end(); ?>