<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

$this->title = 'Registration Wizard Complete';

echo Html::beginTag('div', ['class' => 'section']);
echo Html::tag('h2', 'mainData');
echo DetailView::widget([
    'model' => $data['mainData'][0],
    'attributes' => [
        'honorific_prefix',
        'given_name',
        'family_name',
        'date_of_birth'
    ]
]);
echo Html::endTag('div');

echo Html::beginTag('div', ['class' => 'section']);
echo Html::tag('h2', 'contactData');
echo DetailView::widget([
    'model' => $data['contactData'][0],
    'attributes' => [
        'street_address',
        'locality',
        'region',
        'postal_code'
    ]
]);
echo Html::endTag('div');

echo Html::beginTag('div', ['class' => 'section']);
echo Html::tag('h2', 'rubricData');
foreach ($data['rubricData'] as $phoneNumber) {
    echo DetailView::widget([
        'model' => $phoneNumber,
        'attributes' => [
            'type',
            'value'
        ]
    ]);
}
echo Html::endTag('div');

echo Html::a('На главную', Url::home());
