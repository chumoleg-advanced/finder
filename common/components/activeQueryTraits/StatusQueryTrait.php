<?php

namespace common\components\activeQueryTraits;

use common\components\Status;

trait StatusQueryTrait
{
    /**
     * @param int $status
     *
     * @return $this
     */
    public function filterStatus($status)
    {
        return $this->andFilterWhere(['[[' . $this->getStatusAttributeName() . ']]' => $status]);
    }

    /**
     * @return string
     */
    protected function getStatusAttributeName()
    {
        return 'status';
    }

    /**
     * @return $this
     */
    public function isActive()
    {
        return $this->whereStatus(Status::STATUS_ACTIVE);
    }

    /**
     * @param int $status
     *
     * @return $this
     */
    private function whereStatus($status)
    {
        return $this->andWhere(['[[' . $this->getStatusAttributeName() . ']]' => $status]);
    }

    /**
     * @return $this
     */
    public function isBlocked()
    {
        return $this->whereStatus(Status::STATUS_DISABLED);
    }
}