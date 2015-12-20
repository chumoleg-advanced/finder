<?php

namespace common\models\user;

/**
 * This is the ActiveQuery class for [[UserSetting]].
 *
 * @see UserSetting
 */
class UserSettingQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return UserSetting[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return UserSetting|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}