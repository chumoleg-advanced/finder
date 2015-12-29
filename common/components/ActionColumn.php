<?php

namespace common\components;

use Yii;
use yii\base\Exception;

class ActionColumn extends \yii\grid\ActionColumn
{
    protected function initDefaultButtons()
    {
        $buttons = [
            'view',
            'update',
            'delete',
            'accept',
            'reject',
            'reset',
            'moderate',
            'offer',
        ];

        foreach ($buttons as $buttonName) {
            if (isset($this->buttons[$buttonName])) {
                continue;
            }

            $this->buttons[$buttonName] = function ($url, $model, $key) use ($buttonName) {
                try {
                    return ManageButton::$buttonName($url);
                } catch (Exception $e) {
                }

                return null;
            };
        }
    }
}