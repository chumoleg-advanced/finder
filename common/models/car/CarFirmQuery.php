<?php

namespace common\models\car;

use \yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[CarFirm]].
 *
 * @see CarFirm
 */
class CarFirmQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return CarFirm[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CarFirm|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}