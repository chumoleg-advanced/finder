<?php
$this->title = 'Организация ' . $model->legal_name;
?>

<div class="news-index">
    <legend><?= $this->title; ?></legend>

    <?php
    echo \yii\widgets\DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'legal_name',
            'actual_name',
            'form',
            'inn',
            'ogrn',
        ]
    ]);
    ?>
</div>