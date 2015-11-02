<?php

namespace common\models\wheelParam;

use \yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[WheelParam]].
 *
 * @see WheelParam
 */
class WheelParamQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return WheelParam[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return WheelParam|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}