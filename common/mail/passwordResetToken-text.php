<?php

/* @var $this yii\web\View */
/* @var $user common\models\user\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/reset-password', 'token' => $user->password_reset_token]);
?>
Hello <?= $user->email ?>,

Follow the link below to reset your password:

<?= $resetLink ?>
