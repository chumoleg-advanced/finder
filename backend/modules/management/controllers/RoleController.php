<?php

namespace backend\modules\management\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\rbac\Role;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\web\NotFoundHttpException;

class RoleController extends Controller
{
    public $defaultAction = 'role';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'manage'],
                        'allow'   => true,
                        'roles'   => ['roleManage'],
                    ],
                ],
            ]
        ];
    }

    public function actionIndex()
    {
        return $this->render('index', [
            'dataProvider' => $this->getDataProvider(Yii::$app->authManager->getRoles())
        ]);
    }

    /**
     * @param $data
     *
     * @return ArrayDataProvider
     */
    private function getDataProvider($data)
    {
        $dataProvider = new ArrayDataProvider([
            'allModels'  => $data,
            'sort'       => [
                'attributes' => ['name', 'description'],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $dataProvider;
    }

    /**
     * @param string $name
     *
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionManage($name)
    {
        $role = Yii::$app->authManager->getRole($name);

        if ($role instanceof Role) {
            $permissions = ArrayHelper::map(Yii::$app->authManager->getPermissions(), 'name', 'description');
            $rolePermit = array_keys(Yii::$app->authManager->getPermissionsByRole($name));

            $permissionsData = Yii::$app->request->post('permissions');
            if (!empty($permissionsData)) {
                Yii::$app->authManager->removeChildren($role);
                $this->savePermissions(Yii::$app->request->post('permissions', []), $role);

                return $this->redirect(['/permit/role/index']);
            }

            return $this->render('manage', [
                'role'        => $role,
                'permissions' => $permissions,
                'rolePermit'  => $rolePermit
            ]);
        } else {
            throw new NotFoundHttpException(Yii::t('error', 'Role is not found'));
        }
    }

    /**
     * @param array $permissions
     * @param Role  $role
     */
    private function savePermissions($permissions, $role)
    {
        foreach ($permissions as $permit) {
            $newPermit = Yii::$app->authManager->getPermission($permit);
            Yii::$app->authManager->addChild($role, $newPermit);
        }
    }
}