<?php

namespace common\models\request;

use common\models\company\Company;
use common\models\company\CompanyRubric;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class RequestSearch extends Request
{
    public $categoryId;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'date_create', 'categoryId', 'rubric_id', 'performer_company_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'categoryId' => 'Категория'
        ]);
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

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if ($this->performer_company_id == 0) {
            $this->performer_company_id = null;
        }

        $query->andFilterWhere([
            'id'                   => $this->id,
            'status'               => $this->status,
            'rubric_id'            => $this->rubric_id,
            'performer_company_id' => $this->performer_company_id,
            'date_create'          => $this->date_create
        ]);

        if (!empty($this->categoryId)) {
            $query->andFilterWhere(['rubric.category_id' => $this->categoryId]);
        }

        if (Yii::$app->user->can('accessToPersonalCabinet')) {
            if ($type == 'user') {
                $query->andWhere(['user_id' => Yii::$app->user->id]);

            } elseif ($type == 'company') {
                $query->andWhere(['performer_company_id' => array_keys(Company::getListByUser())]);

            } elseif ($type == 'free') {
                $myRubrics = CompanyRubric::find()->joinWith('company')
                    ->andWhere(['company.user_id' => Yii::$app->user->id])->distinct('rubric_id')->all();

                $query->andWhere(['rubric_id' => ArrayHelper::getColumn($myRubrics, 'rubric_id')]);
                $query->andWhere(['status' => self::STATUS_OFFER_SENT]);
            }
        }

        return $dataProvider;
    }
}
