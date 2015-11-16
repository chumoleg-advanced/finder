<div class="form-group">
    <div class="col-md-offset-2 col-md-10 col-sm-12 col-xs-12">
        <hr/>
        <?= $form->field($model, 'verifyCode')->widget(\yii\captcha\Captcha::className(), [
            'captchaAction' => '/site/captcha',
            'options'       => ['class' => 'form-control'],
            'template'      => '<div class="col-md-3 col-sm-3 col-xs-6">{image}</div>
                    <div class="col-md-5 col-sm-5 col-xs-6">{input}</div><div class="col-md-4 col-sm-4"></div>',
        ]); ?>
    </div>
</div>