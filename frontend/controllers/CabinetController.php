<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use frontend\components\Controller;

class CabinetController extends Controller
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
                        'roles'   => ['accessToPersonalCabinet'],
                    ],
                ],
            ],
        ];
    }

    public function init()
    {
        $this->layout = 'personalCabinet';
    }

    public function actionIndex()
    {
        return $this->render('index', []);
    }
}
