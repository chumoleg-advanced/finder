<?php

namespace common\components\actions;

use Yii;
use yii\base\Action;
use yii\web\BadRequestHttpException;

class ChangeStatusAction extends Action
{
    public $status;

    public function run($id)
    {
        if (empty($id)) {
            throw new BadRequestHttpException();
        }

        $model = $this->controller->loadModel($id);
        if (empty($model)) {
            return $this->controller->redirect(['index']);
        }

        $model->updateStatus($this->status);

        return $this->controller->redirect(['index']);
    }
}
