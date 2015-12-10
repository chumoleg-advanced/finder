<?php
use \yii\captcha\Captcha;

?>

<div class="form-group">
    <div class="col-md-offset-2 col-md-10 col-sm-12 col-xs-12">
        <hr/>
        <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
            'options'  => ['class' => 'form-control verifyCodeInput'],
            'template' => '<div class="col-md-2 col-sm-2 col-xs-6">{image}</div>
                    <div class="col-md-4 col-sm-4 col-xs-6">{input}</div>',
        ]); ?>
    </div>
</div>