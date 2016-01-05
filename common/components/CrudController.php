<?php

namespace common\components;

use Yii;
use backend\components\Controller;
use yii\web\NotFoundHttpException;

abstract class CrudController extends Controller
{
    public function actionIndex()
    {
        $model = $this->getSearchModel();

        $searchModel = new $model();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    abstract protected function getSearchModel();

    /**
     * @param $id
     *
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('form', [
                'model' => $model
            ]);
        }
    }

    /**
     * @param $id
     *
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function loadModel($id)
    {
        $formModel = $this->getModel();
        $model = $formModel::findOne($id);
        if (empty($model)) {
            throw new NotFoundHttpException('Страница не найдена');
        }

        return $model;
    }

    abstract protected function getModel();

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $formModel = $this->getModel();
        $model = new $formModel();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
}