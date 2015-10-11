<?php

/* @var $this yii\web\View */
/* @var $categories common\models\category\Category[] */

$this->title = 'My Yii Application';
?>

<div>&nbsp;</div>
<p class="lead">Выберите категорию:</p>
<div>&nbsp;</div>

<div class="row">
    <?php foreach ($categories as $category) : ?>
        <div class="col-lg-4" style="height: 80px; text-align: center;">
            <a class="btn btn-default" href="/site/category/<?= $category->id; ?>"><?= $category->name; ?></a>
        </div>
    <?php endforeach; ?>
</div>
