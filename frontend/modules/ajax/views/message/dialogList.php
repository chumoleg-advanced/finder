<?php
/** @var MessageDialog[] $data */

use yii\helpers\Html;
use common\models\MessageDialog;

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
            <?= Html::a($item->getDialogDescription(), 'javascript:;', [
                'class'   => 'rowRequestMessage',
                'data-id' => $item->id
            ]); ?>
        </div>
    </div>
<?php endforeach; ?>