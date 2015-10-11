<?php

namespace common\models\user;

use common\components\activeQueryTraits\CommonQueryTrait;
use common\components\activeQueryTraits\StatusQueryTrait;
use yii\db\ActiveQuery;

class UserQuery extends ActiveQuery
{
    use CommonQueryTrait,
        StatusQueryTrait;

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