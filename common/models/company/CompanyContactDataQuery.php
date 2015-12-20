<?php

namespace common\models\company;

/**
 * This is the ActiveQuery class for [[CompanyContactData]].
 *
 * @see CompanyContactData
 */
class CompanyContactDataQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return CompanyContactData[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CompanyContactData|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}