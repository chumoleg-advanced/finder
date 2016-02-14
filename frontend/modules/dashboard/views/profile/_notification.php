<?php
use yii\helpers\Html;
use common\models\notification\Notification;

?>

<div>&nbsp;</div>
<div class="row">
    <div class="col-md-4 col-xs-12">
        <legend>Получать уведомления:</legend>
        <?= Html::checkboxList('notificationList', $selected,
            Notification::$typeListForUser, ['class' => 'notificationList']); ?>
    </div>
</div>