<?php
use yii\helpers\Html;

if (!isset($visiblePrev)) {
    $visiblePrev = true;
}

if (!isset($visibleNext)) {
    $visibleNext = true;
}

if (!isset($visibleDone)) {
    $visibleDone = false;
}
?>

<div class="form-row buttons">
    <?php
    if ($visiblePrev) {
        echo Html::submitButton('Prev', ['class' => 'btn btn-warning', 'name' => 'prev', 'value' => 'prev']);
    }

    if ($visibleNext) {
        echo Html::submitButton('Next', ['class' => 'btn btn-success', 'name' => 'next', 'value' => 'next']);
    }

    if ($visibleDone) {
        echo Html::submitButton('Done', ['class' => 'btn btn-primary', 'name' => 'next', 'value' => 'next']);
    }
    ?>
</div>
