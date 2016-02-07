<?php
/** @var \common\models\Message[] $data */

use yii\helpers\Html;

?>

<?php if (empty($data)) : ?>
    <div class="row">
        <div class="col-md-12">
            <h4>Сообщений нет</h4>
        </div>
    </div>
<?php endif; ?>

<?php foreach ($data as $item) : ?>
    <div class="row">
        <div class="col-md-12">
            <?php
            $messageBadge = '';
            if ($item->countNew > 0) {
                $messageBadge = '<span class="badge">' . $item->countNew . '</span>';
            }

            echo Html::a('Заявка №' . $item->request_id . '. ' . $item->request->description . ' ' . $messageBadge,
                'javascript:;', [
                    'class'        => 'rowRequestMessage',
                    'data-request' => $item->request_id,
                    'data-to-user' => $item->from_user_id != Yii::$app->user->id ? $item->from_user_id
                        : $item->to_user_id
                ]);
            ?>
        </div>
    </div>
<?php endforeach; ?>