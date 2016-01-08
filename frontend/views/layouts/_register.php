<?php

use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use app\forms\SignUpForm;
use yii\helpers\Url;

$this->title = 'Регистрация';
$model = new SignUpForm();
?>

<?php Modal::begin(['id' => 'signUpForm', 'header' => Html::tag('h3', $this->title)]); ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="site-signup">
                <?php $form = ActiveForm::begin([
                    'id'                     => 'signup-form',
                    'enableAjaxValidation'   => true,
                    'enableClientValidation' => false,
                    'validationUrl'          => Url::to('/auth/signup-validate'),
                ]);
                ?>

                <div class="row">
                    <div class="col-md-12">
                        <?php
                        echo $form->field($model, 'email')->textInput(
                            ['placeholder' => $model->getAttributeLabel('email')]);
                        echo $form->field($model, 'password')->passwordInput(
                            ['placeholder' => $model->getAttributeLabel('password')]);
                        echo $form->field($model, 'confirmPassword')->passwordInput(
                            ['placeholder' => $model->getAttributeLabel('confirmPassword')]);
                        ?>
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