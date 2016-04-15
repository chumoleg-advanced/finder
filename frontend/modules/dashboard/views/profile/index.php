<?php
$this->title = 'Мои настройки';

\frontend\assets\UserProfileAsset::register($this);
?>
<div class="container layout">
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <?php
        echo \yii\bootstrap\Tabs::widget([
            'id'    => 'personalSettings',
            'items' => [
                [
                    'label'   => 'Общие настройки',
                    'content' => $this->render('_commonSettings', ['model' => $model]),
                    'active'  => true
                ],
                [
                    'label'   => 'Настройка уведомлений',
                    'content' => $this->render('_notification', [
                        'model'    => $model,
                        'selected' => $selectedNotification
                    ]),
                ]
            ],
        ]);
        ?>
    </div>
</div>
</div>