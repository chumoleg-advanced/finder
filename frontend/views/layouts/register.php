<?php

use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use frontend\forms\SignupForm;

$this->title = 'Регистрация';
$model = new SignupForm();
?>

<?php Modal::begin(['id' => 'signUpForm', 'header' => Html::tag('h3', $this->title)]); ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="site-signup">
                <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <div class="row">
                    <div class="col-lg-5">
                        <?= $form->field($model, 'username'); ?>
                        <?= $form->field($model, 'password')->passwordInput(); ?>
                        <?= $form->field($model, 'email'); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <?= Html::submitButton('Зарегистрироваться',
                    ['class' => 'btn btn-primary', 'name' => 'signup-button']); ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
<?php Modal::end(); ?>