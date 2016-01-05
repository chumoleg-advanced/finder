<?php

namespace common\models\company;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class CompanySearch extends Company
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'id',
                    'status',
                    'city_id',
                    'user_id',
                    'form',
                    'date_create',
                    'legal_name',
                    'actual_name',
                    'inn',
                    'ogrn'
                ],
                'safe'
            ],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = parent::find();
        $dataProvider = $this->getDataProvider($query);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id'          => $this->id,
            'status'      => $this->status,
            'date_create' => $this->date_create
        ]);

        return $dataProvider;
    }

    public function getUserList()
    {
        return ArrayHelper::map(self::find()->joinWith('user')->all(), 'user.id', 'user.email');
    }
}
