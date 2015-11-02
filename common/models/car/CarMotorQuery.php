<?php

namespace common\models\car;

use \yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[CarMotor]].
 *
 * @see CarMotor
 */
class CarMotorQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return CarMotor[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CarMotor|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}