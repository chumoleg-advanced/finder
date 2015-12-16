<?php

namespace common\models\user;

use common\components\activeQueryTraits\CommonQueryTrait;
use common\components\activeQueryTraits\StatusQueryTrait;
use common\components\activeQueryTraits\UserQueryTrait;
use yii\db\ActiveQuery;

class UserQuery extends ActiveQuery
{
    use CommonQueryTrait,
        StatusQueryTrait,
        UserQueryTrait;

    /**
     * @param string $token
     *
     * @return $this
     */
    public function wherePasswordResetToken($token)
    {
        return $this->andWhere(['password_reset_token' => $token]);
    }

    /**
     * @inheritdoc
     * @return User[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return User|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}