<?php

namespace common\components\behaviors;

use yii\base\Behavior;
use yii\db\BaseActiveRecord;

class StatusBehavior extends Behavior
{
    const STATUS_ACTIVE = 1;
    const STATUS_DISABLED = 2;

    public $statusAttributeName = 'status';
    public $defaultStatus = self::STATUS_ACTIVE;
    public $statusesList
        = [
            self::STATUS_ACTIVE   => self::STATUS_ACTIVE,
            self::STATUS_DISABLED => self::STATUS_DISABLED,
        ];

    public function events()
    {
        return [
            BaseActiveRecord::EVENT_BEFORE_INSERT => [$this, 'handlerBeforeInsert'],
        ];
    }

    public function handlerBeforeInsert($event)
    {
        $sender = $event->sender;
        if (empty($sender->getAttribute($this->statusAttributeName))) {
            $sender->setAttribute($this->statusAttributeName, $this->defaultStatus);
        }
    }

    public function setStatus($status)
    {
        $owner = $this->owner;
        $owner->setAttribute($this->statusAttributeName, $status);
        return $owner;
    }

    public function getStatusLabels()
    {
        $allStatuses = [
            self::STATUS_ACTIVE   => \Yii::t('app', 'Enabled'),
            self::STATUS_DISABLED => \Yii::t('app', 'Disabled'),
        ];

        return array_intersect_key($allStatuses, $this->statusesList);
    }
}
