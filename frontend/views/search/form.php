<?php

/* @var $this yii\web\View */
/* @var $rubric common\models\rubric\Rubric */

use \yii\helpers\Url;
use \yii\helpers\Html;
use app\assets\FormCarSearchAsset;

FormCarSearchAsset::register($this);

$this->title = Yii::t('title', 'Search');

echo Html::tag('legend', 'Создание заявки в рубрике "' . $rubric->name . '"');

if (!isset($hideBackLink)) {
    echo Html::a('К списку рубрик', Url::toRoute(['/search/category', 'id' => $rubric->category_id]));
}

echo Html::tag('div', '&nbsp;');
echo $this->render($formView, ['model' => $formModel, 'rubric' => $rubric]);
