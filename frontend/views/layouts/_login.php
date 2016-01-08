<?php

use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use common\forms\LoginForm;

$this->title = 'Авторизация';
$model = new LoginForm();
?>

<?php Modal::begin(['id' => 'loginForm', 'header' => Html::tag('h3', $this->title)]); ?>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div>
                <?= Html::a('Я еще не зарегистрирован!', '#', ['class' => 'loginIfRegister']); ?>
            </div>
            <div>&nbsp;</div>

            <?php
            $form = ActiveForm::begin([
                'id'                     => 'login-form',
                'enableAjaxValidation'   => true,
                'enableClientValidation' => false,
                'validateOnBlur'         => false,
                'validateOnChange'       => false,
                'validateOnSubmit'       => true,
                'validationUrl'          => Url::to('/auth/login-validate'),
            ]);
            ?>

            <?= $form->field($model, 'email')->textInput(
                ['placeholder' => $model->getAttributeLabel('email')]); ?>
            <?= $form->field($model, 'password')->passwordInput(
                ['placeholder' => $model->getAttributeLabel('password')]); ?>

            <div style="color:#999;margin:1em 0">
                <?= Html::a('Забыли пароль?', ['auth/request-password-reset']); ?>
            </div>

            <?= $form->field($model, 'rememberMe')->checkbox(); ?>

            <div class="form-group">
                <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']); ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
<?php Modal::end(); ?>