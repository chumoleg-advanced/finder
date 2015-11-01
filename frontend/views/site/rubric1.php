<?php

/* @var $this yii\web\View */
/* @var $rubrics common\models\rubric\Rubric[] */

use \yii\helpers\Html;
use \yii\helpers\Url;
use himiklab\thumbnail\EasyThumbnailImage;

$this->title = Yii::t('title', 'Rubrics');

echo Html::a('К списку категорий', Url::toRoute('/site/index'));
echo Html::tag('div', '&nbsp;');
?>

<div>&nbsp;</div>
<p class="lead">Выберите рубрику:</p>
<div>&nbsp;</div>

<div class="row">
    <?php foreach ($rubrics as $rubric) : ?>
        <div class="text-center col-lg-2 col-md-4 col-sm-6 col-xs-12">
            <a href="<?= Url::toRoute(['/site/form', 'id' => $rubric->id]); ?>">
                <?= EasyThumbnailImage::thumbnailImg('img/NoImage.jpg', 100, 100,
                    EasyThumbnailImage::THUMBNAIL_OUTBOUND,
                    ['class' => 'img-responsive img-thumbnail', 'alt' => $rubric->name]
                ); ?><br/>
                <?= $rubric->name; ?>
            </a>
        </div>
    <?php endforeach; ?>
</div>
