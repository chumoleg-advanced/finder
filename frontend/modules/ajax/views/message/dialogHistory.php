<?php
/** @var \common\models\Message[] $dialogHistory */
/** @var \common\models\request\Request $request */

?>

<div class="dialogHistory">
    <?php foreach ($dialogHistory as $item) : ?>
        <?php
        $my = $item->from_user_id == Yii::$app->user->id;
        $from = $my ? 'Я' : ($request->user_id == $item->to_user_id ? 'Компания' : 'Клиент');
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
