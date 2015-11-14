<div class="form-group">
    <div class="col-md-offset-2 col-md-10">
        <hr/>
        <?= $form->field($model, 'verifyCode')->widget(\yii\captcha\Captcha::className(), [
            'captchaAction' => '/site/captcha',
            'options'       => ['class' => 'form-control'],
            'template'      => '<div class="col-md-3 text-right">{image}</div>
                    <div class="col-md-3">{input}</div><div class="col-md-6"></div>',
        ]); ?>
    </div>
</div>