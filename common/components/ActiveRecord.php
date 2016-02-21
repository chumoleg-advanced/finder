<?php

namespace common\components;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;

class ActiveRecord extends \yii\db\ActiveRecord
{
    /**
     * @param int $id
     *
     * @return null|string
     */
    public static function getNameById($id)
    {
        $id = (int)$id;
        if (empty($id)) {
            return null;
        }

        $model = self::find()->andWhere(['id' => $id])->one();
        return !empty($model) ? $model->name : null;
    }

    /**
     * @param $id
     *
     * @return static
     */
    public static function findById($id)
    {
        return self::find()->andWhere(['id' => $id])->one();
    }

    public function behaviors()
    {
        return [
            'dateCreate' => [
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
     * @param        $query
     * @param string $field
     */
    public function andWhereUser($query, $field = 'user_id')
    {
        if (Yii::$app->user->can('accessToBackend')) {
            return;
        }

        $query->andWhere([$field => Yii::$app->user->id]);
    }

    /**
     * @param        $query
     * @param array  $defaultOrder
     *
     * @return ActiveDataProvider
     */
    protected function getDataProvider($query, $defaultOrder = [])
    {
        if (empty($defaultOrder)) {
            $defaultOrder = ['id' => SORT_DESC];
        }

        return new ActiveDataProvider([
            'query'      => $query,
            'sort'       => [
                'defaultOrder' => $defaultOrder
            ],
            'pagination' => [
                'pageSize' => 20,
            ]
        ]);
    }
}