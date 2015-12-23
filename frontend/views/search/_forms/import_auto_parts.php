<?php

use common\components\Status;
use common\models\car\CarFirm;
use app\components\SearchFormGenerator;

/** @var $model app\searchForms\AutoPartForm */
/** @var $rubric common\models\rubric\Rubric */
/** @var $this \yii\web\View */

// костыль с выбором первоначального состояния запчасти
$selectedCondition = 1;
if ($rubric->id == 10) {
    $selectedCondition = 3;
} elseif ($rubric->id == 11) {
    $selectedCondition = 2;
}

$form = SearchFormGenerator::getFormFiles($rubric->id);
?>

<?= $this->render('_parts/_partOrServiceRow', [
    'form'        => $form,
    'model'       => $model,
    'buttonText'  => 'Добавить еще одну запчасть',
    'placeholder' => 'Наименование запчасти или ОЕМ номер',
    'parts'       => $selectedCondition
]); ?>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10 col-sm-12 col-xs-12">
            <hr/>
            <?= $this->render('_parts/_carSelect', [
                'form'     => $form,
                'model'    => $model,
                'carFirms' => CarFirm::getListByImport(Status::STATUS_ACTIVE)
            ]); ?>
        </div>
    </div>

<?= $this->render('_parts/_needleDelivery', ['form' => $form, 'model' => $model]); ?>
<?= $this->render('_parts/_additionOptionsButton'); ?>
<?= $this->render('_parts/_additionBlock', ['form' => $form, 'model' => $model]); ?>
<?= $this->render('_parts/_captcha', ['form' => $form, 'model' => $model]); ?>
<?= $this->render('_parts/_buttons'); ?>

<?php $form->end(); ?>