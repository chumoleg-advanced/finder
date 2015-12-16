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

    /**
     * @param string $email
     *
     * @return $this
     */
    public function whereEmail($email)
    {
        return $this->andWhere(['email' => $email]);
    }
}