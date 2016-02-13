<?php
/** @var common\models\message\MessageDialog[] $data */

use yii\helpers\Html;

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
                <?= Html::a($item->getDialogDescription(), 'javascript:;', [
                    'class'   => 'rowRequestMessage',
                    'data-id' => $item->id
                ]); ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
