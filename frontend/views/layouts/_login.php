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
            <?php
            echo yii\authclient\widgets\AuthChoice::widget([
                'baseAuthUrl' => ['auth/index'],
                'popupMode'   => true,
                'options'     => [
                    'class' => 'auth-clients-modal'
                ]
            ]);

            $form = ActiveForm::begin([
                'id'                     => 'login-form',
                'enableAjaxValidation'   => true,
                'enableClientValidation' => false,
//                'action'                 => Url::to('/auth/login'),
                'validationUrl'          => Url::to('/auth/login-validate'),
            ]);

            echo $form->field($model, 'email')->textInput(
                ['placeholder' => $model->getAttributeLabel('email')]);
            echo $form->field($model, 'password')->passwordInput(
                ['placeholder' => $model->getAttributeLabel('password')]);
            echo $form->field($model, 'rememberMe')->checkbox();
            ?>

            <div style="color:#999;margin:1em 0">
                <?= Html::a('Забыли пароль?', ['auth/request-password-reset']); ?>
            </div>

            <div class="form-group">
                <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']); ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
<?php Modal::end(); ?>