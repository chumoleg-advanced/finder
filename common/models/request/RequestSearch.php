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
     * @param array  $params
     * @param string $type
     *
     * @return ActiveDataProvider
     */
    public function search($params, $type = null)
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

        if (Yii::$app->user->can('accessToPersonalCabinet')) {
            if ($type == 'user') {
                $query->andWhere(['user_id' => Yii::$app->user->id]);

            } elseif ($type == 'free') {
                $myRubrics = CompanyRubric::find()->joinWith('company')
                    ->andWhere(['company.user_id' => Yii::$app->user->id])->distinct('rubric_id')->all();

                $query->andWhere(['rubric_id' => ArrayHelper::getColumn($myRubrics, 'rubric_id')]);
                $query->andWhere(['status' => self::STATUS_IN_WORK]);
            }
        }

        return $dataProvider;
    }

    public function getUserList()
    {
        return ArrayHelper::map(self::find()->joinWith('user')->distinct('user_id')->all(),
            'user.id', 'user.email');
    }

    public function getStatisticRow()
    {
        return '<i class="glyphicon glyphicon-eye-open" title="Просмотров"></i> ' . $this->count_view
        . ' <i class="glyphicon glyphicon-certificate" style="margin-left: 5px;" title="Предложений"></i> '
        . $this->count_offer . ' <i class="glyphicon glyphicon-comment" style="margin-left: 5px;" title="Сообщений"></i> 0';
    }
}
