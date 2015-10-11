<?php

/* @var $this yii\web\View */
/* @var $rubrics common\models\rubric\Rubric[] */

use kartik\checkbox\CheckboxX;
use \yii\helpers\Html;

$this->title = 'My Yii Application';
?>

<?php
echo Html::a('К списку категорий', '/site/search');
echo Html::tag('div', '&nbsp;');
?>

<div>&nbsp;</div>
<p class="lead">Выберите рубрику:</p>
<div>&nbsp;</div>

<div class="row">
    <?php foreach ($rubrics as $rubric) : ?>
        <div class="col-lg-6">
            <?php echo CheckboxX::widget([
                'name'          => 'rubrics[]',
                'autoLabel'     => true,
                'pluginOptions' => ['threeState' => false],
                'labelSettings' => [
                    'label'    => $rubric->name,
                    'position' => CheckboxX::LABEL_RIGHT
                ]
            ]);
            ?>
        </div>
    <?php endforeach; ?>
</div>

<div>&nbsp;</div>
<div class="row">
    <p><a class="btn btn-lg btn-danger" href="/site/result">Отправить запрос</a></p>
</div>
