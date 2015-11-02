<?php

namespace common\models\autoPart;

use \yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[AutoPart]].
 *
 * @see AutoPart
 */
class AutoPartQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return AutoPart[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AutoPart|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}