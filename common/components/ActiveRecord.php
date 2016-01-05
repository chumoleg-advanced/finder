<?php

namespace common\components;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;

class ActiveRecord extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class'              => TimestampBehavior::className(),
                'createdAtAttribute' => 'date_create',
                'updatedAtAttribute' => null,
            ]
        ];
    }

    /**
     * @param $status
     *
     * @return bool
     */
    public function updateStatus($status)
    {
        if (empty($this->id)) {
            return false;
        }

        if (!isset($this->status)) {
            return true;
        }

        $this->status = $status;
        return $this->save();
    }

    /**
     * @param $query
     *
     * @return ActiveDataProvider
     */
    protected function getDataProvider($query)
    {
        return new ActiveDataProvider([
            'query' => $query,
            'sort'  => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);
    }
}