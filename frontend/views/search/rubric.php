<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->title = Yii::t('title', 'Categories');
?>
<div class="container mainCont carBg">
    <div class="row">
        <div class="col-md-12">
            <?= Html::a('К списку категорий', Url::toRoute('/site/index'), ['class' => 'autoRepair']); ?>
        </div>

        <?php foreach ($rubrics as $k => $rubric) : ?>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a class="whiteCardSub" href="<?= Url::toRoute(['/search/form', 'id' => $rubric->id]); ?>">
                    <div class="icons_repair">
                        <?php if (!empty($rubric->image)) : ?>
                            <img src="<?= $rubric->image; ?>" class="img-responsive">
                        <?php endif; ?>
                    </div>
                    <h4><?= $rubric->name; ?></h4>
                </a>
            </div>
        <?php endforeach; ?>

        <div class="clearfix"></div>
        <div class="col-md-12">
            <?= Html::a('На главную', Url::toRoute('/'), ['class' => 'goHome']); ?>
        </div>
    </div>
</div>

