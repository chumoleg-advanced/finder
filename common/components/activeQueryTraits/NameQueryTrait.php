<?php

namespace common\components\activeQueryTraits;

trait NameQueryTrait
{
    /**
     * @param string $name
     *
     * @return $this
     */
    public function whereName($name)
    {
        return $this->andWhere(['name' => $name]);
    }
}