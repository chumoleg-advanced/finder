<?php

namespace common\models\manufacturer;

use \yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Manufacturer]].
 *
 * @see Manufacturer
 */
class ManufacturerQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return Manufacturer[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Manufacturer|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param int $type
     *
     * @return $this
     */
    public function whereType($type)
    {
        return $this->andWhere(['type' => (int)$type]);
    }
}