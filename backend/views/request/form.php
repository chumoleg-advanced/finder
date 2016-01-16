<?php

use yii\helpers\Html;
use common\models\request\RequestAttribute;
use backend\assets\RequestAsset;

/* @var $this yii\web\View */
/* @var $model common\models\request\Request */

RequestAsset::register($this);

$this->title = 'Заявка №' . $model->id;

echo Html::a('Вернуться к списку', \yii\helpers\Url::toRoute('request/index'),
    ['class' => 'btn btn-default']);
?>
<div>&nbsp;</div>

<?php
$formModelClass = $model->rubric->geFormModelClassName();
$formModel = new $formModelClass();

$requestAttributes = $model->getRequestAttributesData();
$carData = RequestAttribute::getValuesByGroup($requestAttributes, $formModel, RequestAttribute::GROUP_CAR);
$wheelData = RequestAttribute::getValuesByGroup($requestAttributes, $formModel, RequestAttribute::GROUP_WHEEL);
$partData = RequestAttribute::getValuesByGroup($requestAttributes, $formModel, RequestAttribute::GROUP_PART);
$priceData = RequestAttribute::getValuesByGroup($requestAttributes, $formModel, RequestAttribute::GROUP_PRICE);
$deliveryData = RequestAttribute::getValuesByGroup($requestAttributes, $formModel, RequestAttribute::GROUP_DELIVERY);
?>

<div class="row well">
    <?php $form = \kartik\form\ActiveForm::begin(); ?>
    <div class="col-md-6">
        <legend>Запрос</legend>
        <?= $form->field($model, 'rubric_id')->dropDownList(\common\models\rubric\Rubric::getList()); ?>
        <?= $form->field($model, 'description')->textInput(); ?>
        <?= $form->field($model, 'comment')->textInput(); ?>
        <div>&nbsp;</div>

        <?php if (!empty($partData)) : ?>
            <legend>Дополнительная информация</legend>
            <table class="table table-striped table-condensed table-bordered detail-view">
                <?php foreach ($partData as $label => $value) : ?>
                    <tr>
                        <th><?= $label; ?></th>
                        <td><?= $value; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <div>&nbsp;</div>
        <?php endif; ?>

        <?php if (!empty($model->requestImages)) : ?>
            <legend>Изображения</legend>
            <?php foreach ($model->requestImages as $requestImage) : ?>
                <div class="col-md-6">
                    <a class="fancybox" rel="gallery1" href="<?= '/' . $requestImage->name; ?>">
                        <img src="<?= '/' . $requestImage->thumb_name; ?>" alt=""/>
                    </a>
                </div>
            <?php endforeach; ?>
            <div>&nbsp;</div>
        <?php endif; ?>
    </div>

    <div class="col-md-6">
        <?php if (!empty($carData)) : ?>
            <legend>Для автомобиля</legend>

            <table class="table table-striped table-condensed table-bordered detail-view">
                <?php foreach ($carData as $label => $value) : ?>
                    <tr>
                        <th><?= $label; ?></th>
                        <td><?= $value; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <div>&nbsp;</div>
        <?php endif; ?>

        <?php if (!empty($wheelData)) : ?>
            <legend>Параметры шины/диска</legend>

            <table class="table table-striped table-condensed table-bordered detail-view">
                <?php foreach ($wheelData as $label => $value) : ?>
                    <tr>
                        <th><?= $label; ?></th>
                        <td><?= $value; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <div>&nbsp;</div>
        <?php endif; ?>

        <?php if (!empty($priceData)) : ?>
            <legend>Цена</legend>
            <table class="table table-striped table-condensed table-bordered detail-view">
                <?php foreach ($priceData as $label => $value) : ?>
                    <tr>
                        <th><?= $label; ?></th>
                        <td><?= $value; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <div>&nbsp;</div>
        <?php endif; ?>

        <?php if (!empty($deliveryData)) : ?>
            <legend>Информация о доставке</legend>
            <?php
            foreach ($deliveryData as $value) {
                echo $value;
            }
            ?>
        <?php endif; ?>
    </div>
    <?php $form->end(); ?>
</div>

<div class="form-group">
    <?= common\helpers\ButtonHelper::getSubmitButton($model); ?>
</div>
