<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Некорректный шаг';
?>

<div><?= 'Указанный шаг (' . $event->step  . ') недопустим!'; ?></div>
<div>&nbsp;</div>
<?= Html::a('Вернуться', Url::toRoute('company-create/index'), ['class' => 'btn btn-default']); ?>
