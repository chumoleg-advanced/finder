<?php

use common\models\car\CarFirm;
use frontend\components\SearchFormGenerator;
use kartik\helpers\Html;

if (!isset($buttonText)) {
    $buttonText = 'Добавить заявку';
}



/** @var $model frontend\forms\request\AutoServiceForm */
/** @var $rubric common\models\rubric\Rubric */
/** @var $this \yii\web\View */

$form = SearchFormGenerator::getFormFiles($rubric->id);
?>

<div class="row carSelect">
  <div class="rw1170">
    <?= $this->render('_parts/_carSelect',
        ['form' => $form, 'model' => $model, 'carFirms' => CarFirm::getList()]); ?>
    <div class="clearfix"></div>
    <div class="collapse " id="additionCarData">
      <?= $this->render('_parts/_additionCarData', ['form' => $form, 'model' => $model]); ?>
    </div>
    <?= $this->render('_parts/_additionOptionsButton'); ?>
    <div class="clearfix"></div>
  </div>
</div>

<div class="clearfix"></div>

<?= $this->render('_parts/_partOrServiceRow', ['form' => $form, 'model' => $model]); ?>

<div class="row carBg">
  <div class="col-md-12 text-center buttonGroup">
    <?= Html::a('<div class="svg">
        <svg x="0px" y="0px" width="24px" height="24px" viewBox="0 0 512 512">
          <g>
            <g>
              <polygon points="272,128 240,128 240,240 128,240 128,272 240,272 240,384 272,384 272,272 384,272 384,240 272,240    "/>
              <path d="M256,0C114.609,0,0,114.609,0,256c0,141.391,114.609,256,256,256c141.391,0,256-114.609,256-256
                C512,114.609,397.391,0,256,0z M256,472c-119.297,0-216-96.703-216-216S136.703,40,256,40s216,96.703,216,216S375.297,472,256,472
                z"/>
            </g>
          </g>
        </svg>
      </div> ' . $buttonText, '#',
        ['class' => 'btn btn-default svgBtn br2 newButton']); ?>
    <?= $this->render('_parts/_buttons'); ?>
  </div>
</div>

<?php $form->end(); ?>