<?php

namespace common\components\activeQueryTraits;

trait CommonQueryTrait
{
    /**
     * @param $dateCreate
     *
     * @return $this
     */
    public function whereCreatedAt($dateCreate)
    {
        if (!is_string($dateCreate)) {
            return $this;
        }

        $dateCreate = date('Y-m-d', strtotime($dateCreate));
        return $this->andWhere(['DATE(created_at)' => $dateCreate]);
    }
}