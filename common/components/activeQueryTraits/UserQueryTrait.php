<?php

namespace common\components\activeQueryTraits;

trait UserQueryTrait
{
    /**
     * @param int|array $userId
     *
     * @return $this
     */
    public function whereUserId($userId)
    {
        return $this->andWhere(['user_id' => $userId]);
    }
}