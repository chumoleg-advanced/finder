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
        echo Html::submitButton('<< Предыдущий шаг', ['class' => 'btn btn-warning', 'name' => 'prev', 'value' => 'prev']);
    }

    if ($visibleNext) {
        echo Html::submitButton('Следующий шаг >>', ['class' => 'btn btn-success', 'name' => 'next', 'value' => 'next']);
    }

    if ($visibleDone) {
        echo Html::submitButton('Отправить заявку на регистрацию', ['class' => 'btn btn-primary', 'name' => 'next', 'value' => 'next']);
    }
    ?>
</div>
