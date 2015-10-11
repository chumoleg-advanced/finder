<?php

namespace backend\modules\management\controllers;

use common\components\Role;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\user\User;

class PermissionController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['view', 'update'],
                        'allow'   => true,
                        'roles'   => ['userRoleManage'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'update' => ['post'],
                    '*'      => ['get'],
                ],
            ],
        ];
    }

    /**
     * @param int $id
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $user = $this->findUser($id);
        $roles = ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description');
        $userPermit = array_keys(Yii::$app->authManager->getRolesByUser($id));

        return $this->render('view', [
            'user'       => $user,
            'roles'      => $roles,
            'userPermit' => $userPermit
        ]);
    }

    /**
     * @param int $id
     *
     * @return User
     * @throws NotFoundHttpException
     */
    private function findUser($id)
    {
        $user = User::findIdentity($id);
        if (empty($user)) {
            throw new NotFoundHttpException(Yii::t('error', 'User not found'));
        } else {
            return $user;
        }
    }

    /**
     * @param int $id
     *
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $user = $this->findUser($id);
        Yii::$app->authManager->revokeAll($user->getId());
        if (Yii::$app->request->post('roles')) {
            foreach (Yii::$app->request->post('roles') as $roleName) {
                Role::assignRoleForUser($user, $roleName);
            }
        }

        return $this->redirect(['/user/index/index']);
    }
}