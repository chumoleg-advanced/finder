<?php
use kartik\form\ActiveForm;
use yii\helpers\Html;

?>

    <div>&nbsp;</div>
<?php $form = ActiveForm::begin(['id' => 'user-form']); ?>
    <div class="row">
        <div class="col-md-4 col-xs-12">
            <legend>Персональные данные</legend>
            <?php
            echo $form->field($model, 'email')->widget('\yii\widgets\MaskedInput', [
                'name'          => 'email',
                'clientOptions' => ['alias' => 'email'],
            ]);

            echo $form->field($model, 'phone')->widget('\yii\widgets\MaskedInput', [
                'name' => 'phone',
                'mask' => '+7 (999) 999-9999'
            ]);

            echo $form->field($model, 'fio')->textInput(
                ['placeholder' => $model->getAttributeLabel('fio')]);

            echo $form->field($model, 'birthday')->widget('\yii\widgets\MaskedInput', [
                'name'          => 'birthday',
                'clientOptions' => ['alias' => 'date']
            ]);
            ?>

            <div>&nbsp;</div>
            <legend>Изменить пароль</legend>
            <?php
            echo $form->field($model, 'password')->passwordInput(
                ['placeholder' => $model->getAttributeLabel('password')]);
            echo $form->field($model, 'confirmPassword')->passwordInput(
                ['placeholder' => $model->getAttributeLabel('confirmPassword')]);
            ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']); ?>
    </div>

<?php ActiveForm::end(); ?>