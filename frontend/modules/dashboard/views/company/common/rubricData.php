<?php
use common\models\category\Category;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
?>

<?php foreach (Category::getList() as $categoryObj) : ?>
    <div class="companyRubricsList">
        <?= Html::checkbox('category[' . $categoryObj->id . ']', false,
            ['label' => $categoryObj->name, 'class' => 'checkAllRubrics']); ?>

        <div class="categoryRubrics">
            <?php
            $rubrics = ArrayHelper::map($categoryObj->rubrics, 'id', 'name');
            echo $form->field($model, 'rubrics', [
                'template' => "{input}",
                'options'  => ['class' => 'checkBoxButtonFormGroup']
            ])->checkboxList($rubrics, ['unselect' => null]);
            ?>
        </div>
    </div>
<?php endforeach; ?>
