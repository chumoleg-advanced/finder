<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;

$this->title = 'Оповещения';

Modal::begin(['id' => 'messageModal', 'header' => Html::tag('h4', $this->title), 'class' => 'modalBlock']);
?>
    <div class="row">
        <div class="col-md-12 text-center">
            <?= Html::img('/img/bigPreLoader.gif'); ?>
        </div>
    </div>
<?php Modal::end(); ?>