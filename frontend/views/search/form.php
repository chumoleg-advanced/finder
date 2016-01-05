<?php

/* @var $this yii\web\View */
/* @var $rubric common\models\rubric\Rubric */

use \yii\helpers\Url;
use \yii\helpers\Html;
use app\assets\FormCarSearchAsset;

FormCarSearchAsset::register($this);

$this->title = $rubric->name . '. Создание заявки';

if (!isset($hideBackLink)) {
    echo Html::a('К списку рубрик', Url::toRoute(['/search/category', 'id' => $rubric->category_id]));
}
?>

<div class="col-md-offset-2 col-md-10 col-sm-12 col-xs-12">
    <legend><?= $this->title; ?></legend>
</div>

<?= Html::tag('div', '&nbsp;'); ?>
<?= $this->render($formView, ['model' => $formModel, 'rubric' => $rubric]); ?>
