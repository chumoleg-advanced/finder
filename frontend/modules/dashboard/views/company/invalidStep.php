<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Invalid Step';

echo Html::tag('h1', $this->title);
echo Html::tag('div', strtr('Указанный шаг недопустим ({step}).', [
    '{step}' => $event->step
]));
echo Html::a('Продолжить', Url::toRoute('company/create'));
