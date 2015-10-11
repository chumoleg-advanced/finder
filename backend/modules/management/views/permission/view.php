<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $user common\models\user\User */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('title', 'Manage user roles: {email}', ['email' => $user->getEmail()]);
?>

<h3><?= $this->title; ?></h3>
<?php $form = ActiveForm::begin(['action' => ['/user/permission/update', 'id' => $user->getId()]]); ?>

<?= Html::checkboxList('roles', $userPermit, $roles, ['separator' => '<br>']); ?>

<div class="form-group">
    <?= Html::submitButton(Yii::t('button', 'Update'), ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

