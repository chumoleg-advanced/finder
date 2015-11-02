<?php

namespace common\models\car;

use \yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[CarBody]].
 *
 * @see CarBody
 */
class CarBodyQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return CarBody[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CarBody|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}