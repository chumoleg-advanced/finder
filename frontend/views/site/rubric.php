<?php

/* @var $this yii\web\View */
/* @var $rubrics common\models\rubric\Rubric[] */

use kartik\checkbox\CheckboxX;
use \yii\helpers\Html;
use \yii\helpers\Url;

$this->title = Yii::t('title', 'Rubrics');
?>

<?php
echo Html::a('К списку категорий', Url::toRoute('/site/search'));
echo Html::tag('div', '&nbsp;');
?>

<div>&nbsp;</div>
<p class="lead">Выберите рубрику:</p>
<div>&nbsp;</div>

<div class="row">
    <?php foreach ($rubrics as $rubric) : ?>
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <?php echo CheckboxX::widget([
                'name'          => 'rubrics[]',
                'autoLabel'     => true,
                'pluginOptions' => [
                    'threeState' => false
                ],
                'labelSettings' => [
                    'label'    => $rubric->name,
                    'position' => CheckboxX::LABEL_RIGHT
                ]
            ]);
            ?>
        </div>
    <?php endforeach; ?>

    <div class="col-lg-12">
        <div>&nbsp;</div>
        <a class="btn btn-lg btn-danger" href="<?= Url::toRoute('/site/form'); ?>">Далее</a>
    </div>
</div>
