<?php

namespace common\models\request;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use common\models\company\CompanyRubric;

class RequestSearch extends Request
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'categoryId', 'rubric_id', 'user_id'], 'integer'],
            [['description', 'date_create'], 'safe']
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
        $query->joinWith('rubric');

        $dataProvider = $this->getDataProvider($query);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'request.id'                => $this->id,
            'request.status'            => $this->status,
            'request.rubric_id'         => $this->rubric_id,
            'request.user_id'           => $this->user_id,
            'DATE(request.date_create)' => $this->date_create
        ]);

        $query->andFilterWhere(['like', 'description', $this->description]);

        if (!empty($this->categoryId)) {
            $query->andFilterWhere(['rubric.category_id' => $this->categoryId]);
        }

        $this->andWhereUser($query, 'request.user_id');

        return $dataProvider;
    }

    public function getUserList()
    {
        return ArrayHelper::map(self::find()->joinWith('user')->distinct('user_id')->all(),
            'user.id', 'user.email');
    }

    public function getCategoryList()
    {
        $query = self::find()->joinWith('rubric.category')->distinct('rubric_id');
        $this->andWhereUser($query, 'request.user_id');

        return ArrayHelper::map($query->all(), 'rubric.category.id', 'rubric.category.name');
    }

    public function getRubricList()
    {
        $query = self::find()->joinWith('rubric')->distinct('rubric_id');
        $this->andWhereUser($query, 'request.user_id');

        return ArrayHelper::map($query->all(), 'rubric.id', 'rubric.name');
    }

    public function getStatisticRow()
    {
        $countOffers = count($this->requestOffers);
        return '<i class="glyphicon glyphicon-eye-open" title="Просмотров"></i> ' . $this->count_view
        . ' <i class="glyphicon glyphicon-certificate" style="margin-left: 5px;" title="Предложений"></i> '
        . $countOffers . ' <i class="glyphicon glyphicon-comment" style="margin-left: 5px;" title="Сообщений"></i> 0';
    }
}
