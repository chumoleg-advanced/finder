<?php
/** @var MainData $model */

use common\models\city\City;
use app\modules\dashboard\forms\company\MainData;
use app\modules\dashboard\components\CompanyCreateForm;
use app\assets\DashboardMainAsset;

DashboardMainAsset::register($this);

$this->title = 'Общая информация';

echo $this->render('_wizardMenu', ['event' => $event]);

if (empty($model->form)){
    $model->form = MainData::FORM_JURIDICAL;
}

$form = CompanyCreateForm::getForm($event->step);
?>

<div class="row">
    <div class="col-md-6">
        <?php
        echo $form->field($model, 'city_id')->dropDownList(City::getList());

        echo $form->field($model, 'form', ['options' => ['class' => 'form-group radioButtonFormGroup']])
            ->radioButtonGroup(MainData::getFormList(), [
                'class'       => 'btn-group companyFormGroup',
                'itemOptions' => ['labelOptions' => ['class' => 'btn btn-default']]
            ]);

        echo $form->field($model, 'legal_name', ['options' => ['class' => 'form-group legalNameForm']])
            ->textInput(['maxlength' => 250]);
        echo $form->field($model, 'actual_name', ['options' => ['class' => 'form-group actualNameForm']])
            ->textInput(['maxlength' => 250]);
        echo $form->field($model, 'fio', ['options' => ['class' => 'form-group fioForm']])
            ->textInput(['maxlength' => 250]);
        echo $form->field($model, 'inn', ['options' => ['class' => 'form-group innForm']])
            ->textInput(['maxlength' => 12]);
        echo $form->field($model, 'ogrn', ['options' => ['class' => 'form-group ogrnForm']])
            ->textInput(['maxlength' => 15]);
        echo $form->field($model, 'ogrnip', ['options' => ['class' => 'form-group ogrnipForm']])
            ->textInput(['maxlength' => 15]);

        echo $this->render('_buttons', ['visiblePrev' => false]);
        ?>
    </div>
</div>
<?php $form->end(); ?>
