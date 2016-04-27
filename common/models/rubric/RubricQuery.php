<?php

namespace common\models\rubric;

use \yii\db\ActiveQuery;
use common\components\activeQueryTraits\CommonQueryTrait;

/**
 * This is the ActiveQuery class for [[Rubric]].
 *
 * @see Rubric
 */
class RubricQuery extends ActiveQuery
{
    use CommonQueryTrait;

    /**
     * @inheritdoc
     * @return Rubric[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Rubric|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}