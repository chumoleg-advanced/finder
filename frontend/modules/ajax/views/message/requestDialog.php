<?php
/** @var \common\models\Message $model */
/** @var \common\models\Message[] $dialogHistory */

use kartik\form\ActiveForm;
use yii\helpers\Html;

?>

<?php if (isset($showBack)) : ?>
    <div><a href="javascript:;" class="returnBackDialogList">Вернуться к списку диалогов</a></div>
    <div>&nbsp;</div>
<?php endif; ?>

<?= $this->render('dialogHistory', ['dialogHistory' => $dialogHistory, 'request' => $request]); ?>

<div class="row">
    <div class="col-md-12">
        <?php
        $form = ActiveForm::begin([
            'id'          => 'message-form',
            'action'      => '/ajax/message/send-message',
            'fieldConfig' => [
                'template' => "{input}\n{hint}\n{error}"
            ],
        ]);

        echo $form->field($model, 'data')->textarea(
            ['placeholder' => $model->getAttributeLabel('data'), 'class' => 'textArea']);

        echo $form->field($model, 'to_user_id')->hiddenInput();
        echo $form->field($model, 'request_id')->hiddenInput();
        $form->end();
        ?>

        <div class="form-group">
            <?= Html::button('Отправить',
                ['class' => 'btn btn-primary', 'name' => 'message-button', 'id' => 'sendMessageButton']); ?>
        </div>
    </div>
</div>