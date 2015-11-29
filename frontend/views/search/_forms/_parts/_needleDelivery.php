<?php
use \kartik\widgets\Typeahead;
use \yii\helpers\Url;
use mirocow\yandexmaps\Canvas as YandexCanvas;

?>

<div class="col-md-6 col-sm-6 col-xs-12">
    <?= $form->field($model, 'delivery')->checkbox(['class' => 'showDeliveryAddress']); ?>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 deliveryAddress">
    <?= $form->field($model, 'deliveryAddress')->widget(Typeahead::className(), [
        'options'       => ['placeholder' => 'Укажите адрес', 'class' => 'form-control'],
        'pluginOptions' => ['highlight' => true, 'minLength' => 3],
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

    <?php
    $map = new \mirocow\yandexmaps\Map('yandex_map',
        [
            'center'    => [55.0302, 82.9204],
            'zoom'      => 11,
            'behaviors' => array('default', 'scrollZoom'),
            'type'      => "yandex#map",
        ],
        [
            'minZoom'  => 11,
            'maxZoom'  => 16,
            'controls' => [],
            'events'   => []
        ]
    );

    echo YandexCanvas::widget([
        'htmlOptions' => [
            'style' => 'height: 300px;',
        ],
        'map'         => $map,
    ]);
    ?>
</div>