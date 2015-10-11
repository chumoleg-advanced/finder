<?php

namespace backend\modules\management\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\data\ArrayDataProvider;

class AccessController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow'   => true,
                        'roles'   => ['accessManage'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index', [
            'dataProvider' => $this->getDataProvider(Yii::$app->authManager->getPermissions())
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
}