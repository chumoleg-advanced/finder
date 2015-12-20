<?php

namespace common\models\company;

/**
 * This is the ActiveQuery class for [[CompanyAddress]].
 *
 * @see CompanyAddress
 */
class CompanyAddressQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return CompanyAddress[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CompanyAddress|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}