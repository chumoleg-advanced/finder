<?php

namespace common\components\activeQueryTraits;

trait CategoryQueryTrait
{
    /**
     * @param int|array $categoryId
     *
     * @return $this
     */
    public function whereCategoryId($categoryId)
    {
        return $this->andWhere(['category_id' => $categoryId]);
    }
}