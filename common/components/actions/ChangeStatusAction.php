<?php

namespace common\components\actions;

use Yii;
use yii\base\Action;

class ChangeStatusAction extends Action
{
    public $status;

    public function run($id)
    {
        $model = $this->controller->findModel($id);
        $model->updateStatus($this->status);

        return $this->controller->redirect(['index']);
    }
}
