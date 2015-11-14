<?php

namespace common\models\car;

use \yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[CarEngine]].
 *
 * @see CarEngine
 */
class CarEngineQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return CarEngine[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CarEngine|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}