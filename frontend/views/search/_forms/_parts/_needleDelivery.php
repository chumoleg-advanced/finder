<?php
use \kartik\widgets\Typeahead;
use \yii\helpers\Url;

?>

<div class="col-md-12 col-sm-12 col-xs-12">
    <?= $form->field($model, 'delivery')->checkbox(['class' => 'showDeliveryAddress']); ?>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 deliveryAddress">
    <?= $form->field($model, 'deliveryAddress')->widget(Typeahead::className(), [
        'options'       => ['placeholder' => 'Укажите адрес', 'class' => 'form-control'],
        'pluginOptions' => ['highlight' => true],
        'dataset'       => [
            [
                'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                'display'        => 'value',
                'remote'         => [
                    'url'      => Url::to(['search/address-list']) . '?q=%QUERY',
                    'wildcard' => '%QUERY'
                ]
            ]
        ]
    ]); ?>
</div>