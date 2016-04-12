<?php

use console\components\Migration;
use common\components\Role;

class m151011_163946_addAdminUser extends Migration
{
    public function up()
    {
        try {
            $data = [
                'LoginForm' => [
                    'username'        => 'chumakov.o',
                    'email'           => 'chumakov.o@thor-dev.ru',
                    'password'        => '123456',
                    'confirmPassword' => '123456',
                    'phone'           => '89999999999'
                ]
            ];

            $model = new \frontend\forms\SignUpForm();
            if ($model->load($data)) {
                $model->signUp();
            }

            $rbac = new \console\components\RbacManager();
            $rbac->generate();

            $user = common\models\user\User::find()->whereId(1)->one();
            Role::assignRoleForUser($user, Role::ADMIN);

        } catch (\yii\base\Exception $e) {
        }
    }

    public function down()
    {
        $this->delete('user', 'id = 1');
        $this->execute('ALTER TABLE user AUTO_INCREMENT = 1');
    }
}
