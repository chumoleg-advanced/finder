<?php

namespace common\models\company;

/**
 * This is the ActiveQuery class for [[CompanyRubric]].
 *
 * @see CompanyRubric
 */
class CompanyRubricQuery extends \yii\db\ActiveQuery
{
    /**
     * @inheritdoc
     * @return CompanyRubric[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CompanyRubric|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}