<?php

use common\models\company\Company;
use frontend\modules\dashboard\forms\company\MainData;
use frontend\modules\dashboard\forms\company\ContactData;
use frontend\modules\dashboard\forms\company\RubricData;
use frontend\assets\DashboardMainAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use frontend\modules\dashboard\components\CompanyCreateForm;

DashboardMainAsset::register($this);

/** @var Company $model */

$this->title = 'Компания ' . $model->legal_name;
?>

    <div class="text-bold text-error"><?= Company::$statusList[$model->status]; ?></div>
    <div>&nbsp;</div>

<?php $form = CompanyCreateForm::getForm(null, ['id' => 'company-data-form']); ?>
    <div class="row well">
        <div class="col-md-6">
            <legend>Основная информация</legend>

            <?php
            $mainForm = new MainData();
            $mainForm->attributes = $model->attributes;
            $mainForm->fio = $model->legal_name;
            $mainForm->ogrnip = $model->ogrn;
            $mainForm->companyId = $model->id;

            echo $this->render('common/mainData', ['form' => $form, 'model' => $mainForm]);
            echo $form->field($mainForm, 'companyId', ['template' => '{input}'])->hiddenInput();
            ?>
        </div>

        <div class="col-md-offset-1 col-md-5">
            <legend>Сферы деятельности</legend>

            <?php
            $rubricForm = new RubricData();
            $rubricForm->typePayment = ArrayHelper::getColumn($model->companyTypePayments, 'type');
            $rubricForm->typeDelivery = ArrayHelper::getColumn($model->companyTypeDeliveries, 'type');
            $rubricForm->rubrics = ArrayHelper::getColumn($model->companyRubrics, 'rubric_id');

            echo $this->render('common/rubricData', ['form' => $form, 'model' => $rubricForm]);
            ?>
        </div>
    </div>
    <div>&nbsp;</div>

    <div class="row well">
        <div class="col-md-6">
            <?php
            $contactForm = new ContactData();
            $contactForm->city_id = $model->companyAddresses[0]->city_id;
            $contactForm->address = $model->companyAddresses[0]->address;
            $contactForm->addressCoordinates = $model->companyAddresses[0]->map_coordinates;
            $contactForm->timeWork = $model->companyAddresses[0]->time_work;

            echo $this->render('common/addressData', ['form' => $form, 'model' => $contactForm]);
            ?>

            <div>&nbsp;</div>
            <?= $this->render('common/contactData',
                ['form' => $form, 'model' => $contactForm, 'modelCompany' => $model]); ?>
        </div>

        <div class="col-md-offset-1 col-md-5">
            <?= $this->render('common/typeDelivery', ['form' => $form, 'model' => $rubricForm]); ?>
            <div>&nbsp;</div>
            <?= $this->render('common/typePayment', ['form' => $form, 'model' => $rubricForm]); ?>
        </div>
    </div>

    <div class="row">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>
<?php $form->end(); ?>