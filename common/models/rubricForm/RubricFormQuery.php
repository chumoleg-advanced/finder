<?php

namespace common\models\rubricForm;

use \yii\db\ActiveQuery;
use common\components\activeQueryTraits\CommonQueryTrait;

/**
 * This is the ActiveQuery class for [[RubricForm]].
 *
 * @see RubricForm
 */
class RubricFormQuery extends ActiveQuery
{
    use CommonQueryTrait;

    /**
     * @inheritdoc
     * @return RubricForm[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return RubricForm|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}