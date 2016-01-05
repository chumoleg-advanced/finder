<?php

use app\modules\dashboard\components\CompanyCreateForm;
use common\models\category\Category;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\assets\DashboardMainAsset;
use common\models\company\CompanyTypePayment;
use common\models\company\CompanyTypeDelivery;

DashboardMainAsset::register($this);

$this->title = 'Сфера деятельности';

echo $this->render('_wizardMenu', ['event' => $event]);

$form = CompanyCreateForm::getForm($event->step);
?>

<?php foreach (Category::getList() as $categoryObj) : ?>
    <div class="companyRubricsList">
        <?= Html::checkbox('category[' . $categoryObj->id . ']', false,
            ['label' => $categoryObj->name, 'class' => 'checkAllRubrics']); ?>

        <div class="categoryRubrics">
            <?php
            $rubrics = ArrayHelper::map($categoryObj->rubrics, 'id', 'name');
            echo $form->field($model, 'rubrics', [
                'template' => "{input}",
                'options'  => ['class' => 'checkBoxButtonFormGroup']
            ])->checkboxList($rubrics, ['unselect' => null]);
            ?>
        </div>
    </div>
<?php endforeach; ?>
    <div>&nbsp;</div>

<?php
echo $form->field($model, 'typePayment', [
    'template' => "{label}\n{hint}\n{error}\n{input}",
    'options'  => ['class' => 'checkBoxButtonFormGroup']
])->checkboxList(CompanyTypePayment::getTypeList());
?>
    <div>&nbsp;</div>

<?php
echo $form->field($model, 'typeDelivery', [
    'template' => "{label}\n{hint}\n{error}\n{input}",
    'options'  => ['class' => 'checkBoxButtonFormGroup']
])->checkboxList(CompanyTypeDelivery::getTypeList());
?>
    <div>&nbsp;</div>

<?php
echo $form->field($model, 'timeWork')->textInput();

echo $this->render('_buttons');

$form->end();
