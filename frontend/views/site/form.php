<?php

/* @var $this yii\web\View */
/* @var $rubric common\models\rubric\Rubric */

use \yii\helpers\Url;
use \yii\helpers\Html;

$this->title = Yii::t('title', 'Search');

echo Html::a('К списку рубрик', Url::toRoute(['/site/category', 'id' => $rubric->category_id]));
echo Html::tag('div', '&nbsp;');

echo 'Здесь будет форма: <br />';
echo $this->render('_forms/' . $rubric->rubricForm->name_view, ['rubric' => $rubric]);
