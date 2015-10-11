<?php

namespace common\models\rubric;

use common\components\activeQueryTraits\CategoryQueryTrait;
use common\components\activeQueryTraits\CommonQueryTrait;

/**
 * This is the ActiveQuery class for [[Rubric]].
 *
 * @see Rubric
 */
class RubricQuery extends \yii\db\ActiveQuery
{
    use CommonQueryTrait,
        CategoryQueryTrait;

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