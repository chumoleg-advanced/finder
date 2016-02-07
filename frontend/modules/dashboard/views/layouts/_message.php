<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;

$this->title = 'Диалоги';

Modal::begin(['id' => 'messageModal', 'header' => Html::tag('h3', $this->title), 'class' => 'modalBlock']);
?>
    <div class="row">
        <div class="col-md-12 text-center">
            <?= Html::img('/img/bigPreLoader.gif'); ?>
        </div>
    </div>
<?php Modal::end(); ?>