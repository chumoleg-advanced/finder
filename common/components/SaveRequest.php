<?php

namespace common\components;

use Yii;
use yii\helpers\Url;
use yii\web\UploadedFile;
use frontend\forms\request\QueryArrayForm;

class SaveRequest
{
    /**
     * @param \frontend\forms\request\BaseForm $model
     * @param int                       $rubricId
     *
     * @return bool
     */
    public static function save($model, $rubricId)
    {
        if (!$model->load(Yii::$app->request->post())) {
            return false;
        }

        $modelsOptionValue = Model::createMultiple(QueryArrayForm::classname());
        Model::loadMultiple($modelsOptionValue, Yii::$app->request->post());

        $queryArrayFormData = [];
        foreach ($modelsOptionValue as $index => &$obj) {
            $obj->image = UploadedFile::getInstances($obj, "[{$index}]image");
            $queryArrayFormData[] = $obj->attributes;
        }
        unset($obj);

        if ($model->submitForm($rubricId, $queryArrayFormData)) {
            if (Yii::$app->user->can('accessToPersonalCabinet')) {
                return Url::to(['/dashboard/request/index']);
            }

            return Url::to(['result']);
        }

        return false;
    }
}