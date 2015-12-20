<?php

namespace common\models\company;

/**
 * This is the ActiveQuery class for [[CompanyTypePayment]].
 *
 * @see CompanyTypePayment
 */
class CompanyTypePaymentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return CompanyTypePayment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CompanyTypePayment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}