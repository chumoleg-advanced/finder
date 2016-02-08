<?php
/** @var MessageDialog $messageDialog */

use \common\models\message\MessageDialog;

?>

<div class="dialogHistory">
    <?php foreach ($messageDialog->messages as $item) : ?>
        <?php
        $my = $item->from_user_id == Yii::$app->user->id;
        $from = $my
            ? 'Я'
            : ($messageDialog->sender == MessageDialog::SENDER_COMPANY
            && $messageDialog->from_user_id != Yii::$app->user->id
                ? $messageDialog->company->legal_name : 'Клиент');

        $cssClass = 'dialogMessageForMe';
        if ($my) {
            $cssClass = 'dialogMessageMy';
        }
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="<?= $cssClass; ?>">
                    <div class="messageDate"><?= $item->date_create; ?></div>
                    <?= \yii\helpers\Html::tag('b', $from) . ': ' . nl2br($item->data); ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
