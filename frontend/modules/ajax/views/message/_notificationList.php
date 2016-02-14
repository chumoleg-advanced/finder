<?php
/** @var common\models\notification\Notification[] $data */

use yii\helpers\Html;
use common\models\notification\Notification;

?>
<div>&nbsp;</div>

<?php if (empty($data)) : ?>
    <div class="row">
        <div class="col-md-12">
            <h4>Уведомлений нет</h4>
        </div>
    </div>
<?php else : ?>
    <?php foreach ($data as $item) : ?>
        <div class="row rowMessageInDialogList">
            <div class="col-md-12">
                <div class="messageDate"><?= $item->date_create; ?></div>
                <?= Html::a($item->message, 'javascript:;', [
                    'class'   => 'rowNotification ' . ($item->status == Notification::STATUS_READ
                            ? 'notificationRead' : ''),
                    'data-id' => $item->id
                ]); ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
