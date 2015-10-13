<?php

use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\LoginForm;

$this->title = Yii::t('title', 'Login');
$model = new LoginForm();
?>

<?php Modal::begin(['id' => 'loginForm', 'header' => Html::tag('h2', $this->title)]); ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <?php
            echo Html::tag('legend', Yii::t('title', 'Use social network'));
            echo yii\authclient\widgets\AuthChoice::widget([
                'baseAuthUrl' => ['auth/index'],
                'popupMode'   => true,
                'options'     => [
                    'class' => 'auth-clients-modal'
                ]
            ]);

            echo Html::tag('legend', Yii::t('title', 'or classic auth'));

            $form = ActiveForm::begin(['id' => 'login-form', 'action' => Url::toRoute('/auth/login')]);
            echo $form->errorSummary($model);
            echo $form->field($model, 'username');
            echo $form->field($model, 'password')->passwordInput();
            echo $form->field($model, 'rememberMe')->checkbox();
            ?>
            <div style="color:#999;margin:1em 0">
                If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']); ?>.
            </div>

            <div class="form-group">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']); ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
<?php Modal::end(); ?>