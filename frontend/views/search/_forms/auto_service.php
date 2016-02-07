<?php

use common\models\car\CarFirm;
use frontend\components\SearchFormGenerator;

/** @var $model frontend\forms\request\AutoServiceForm */
/** @var $rubric common\models\rubric\Rubric */
/** @var $this \yii\web\View */

$form = SearchFormGenerator::getFormFiles($rubric->id);
?>

<?= $this->render('_parts/_partOrServiceRow', ['form' => $form, 'model' => $model]); ?>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10 col-sm-12 col-xs-12">
            <hr/>
            <?= $this->render('_parts/_carSelect',
                ['form' => $form, 'model' => $model, 'carFirms' => CarFirm::getList()]); ?>
        </div>
    </div>

<?= $this->render('_parts/_additionOptionsButton'); ?>
<?= $this->render('_parts/_additionBlock', ['form' => $form, 'model' => $model]); ?>
<?= $this->render('_parts/_captcha', ['form' => $form, 'model' => $model]); ?>
<?= $this->render('_parts/_buttons'); ?>

<?php $form->end(); ?>