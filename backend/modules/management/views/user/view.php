<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\user\User */

$this->title = Yii::t('title', 'User data') . ': ' . $model->email;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div>&nbsp;</div>
    <p><?= Html::a(Yii::t('button', 'Edit'), ['update', 'id' => $model->id],
            ['class' => 'btn btn-primary']) ?></p>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'id',
            'email:email',
            'status',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
