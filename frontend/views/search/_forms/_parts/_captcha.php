<?php
use \yii\captcha\Captcha;

?>

<div class="form-group">
    <div class="col-md-offset-2 col-md-10 col-sm-12 col-xs-12">
        <hr/>
        <?= $form->field($model, 'verifyCode', [
            'options' => ['class' => 'verifyCodeBlock form-group']
        ])->widget(Captcha::className(), [
            'options'  => ['class' => 'form-control verifyCodeInput'],
            'template' => '<div class="col-md-3 col-sm-4 col-xs-12">{image}</div>
                    <div class="col-md-4 col-sm-6 col-xs-12">{input}</div>',
        ]); ?>
    </div>
</div>