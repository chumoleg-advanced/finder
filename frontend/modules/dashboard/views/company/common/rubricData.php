<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
?>

<?php foreach (\common\helpers\CategoryHelper::getList() as $id => $item) : ?>
    <div class="companyRubricsList">
        <?= Html::checkbox('category[' . $id . ']', false,
            ['label' => ArrayHelper::getValue($item, 'name'), 'class' => 'checkAllRubrics']); ?>

        <div class="categoryRubrics">
            <?php
            $rubrics = ArrayHelper::getValue($item, 'rubricList', []);
            echo $form->field($model, 'rubrics', [
                'template' => "{input}",
                'options'  => ['class' => 'checkBoxButtonFormGroup']
            ])->checkboxList($rubrics, ['unselect' => null]);
            ?>
        </div>
    </div>
<?php endforeach; ?>
