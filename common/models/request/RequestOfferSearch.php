<?php

namespace common\models\request;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class RequestOfferSearch extends RequestOffer
{
    public $rubricId;
    public $categoryId;
    public $description;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['request_id', 'status', 'categoryId', 'rubricId', 'company_id'], 'integer'],
            [['date_create', 'description'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'categoryId' => 'Категория',
            'rubricId'   => 'Рубрика',
        ]);
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
        $query->joinWith('request.rubric.category');

        $dataProvider = $this->getDataProvider($query);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        if (!empty($this->status)) {
            $query->andWhere([
                'request_offer.status' => [
                    self::STATUS_NEW,
                    self::STATUS_ACTIVE,
                ]
            ]);
        } else {
            $query->andWhere(['<>', 'request.status', Request::STATUS_CLOSED]);
        }

        $query->andFilterWhere([
            'request_offer.id'                => $this->id,
            'request_offer.status'            => $this->status,
            'request_offer.company_id'        => $this->company_id,
            'request_offer.request_id'        => $this->request_id,
            'request.rubric_id'               => $this->rubricId,
            'rubric.category_id'              => $this->categoryId,
            'DATE(request_offer.date_create)' => $this->date_create
        ]);

        $query->andFilterWhere(['like', 'request.description', $this->description]);

        if (Yii::$app->user->can('accessToPersonalCabinet')) {
            $query->andWhere(['request_offer.user_id' => Yii::$app->user->id]);
        }

        return $dataProvider;
    }

    public function getListCategories()
    {
        $data = self::find()
            ->joinWith('request.rubric.category')
            ->distinct('rubric.category_id')
            ->andWhere(['request_offer.user_id' => Yii::$app->user->id])
            ->all();

        return ArrayHelper::map($data, 'request.rubric.category_id', 'request.rubric.category.name');
    }

    public function getListRubrics()
    {
        $data = self::find()
            ->joinWith('request.rubric')
            ->distinct('rubric.id')
            ->andWhere(['request_offer.user_id' => Yii::$app->user->id])
            ->all();

        return ArrayHelper::map($data, 'request.rubric_id', 'request.rubric.name');
    }

    public function getListCompanies()
    {
        $data = self::find()
            ->joinWith('company')
            ->andWhere('company.id IS NOT NULL')
            ->andWhere(['request_offer.user_id' => Yii::$app->user->id])
            ->all();

        return ArrayHelper::map($data, 'company_id', 'company.legal_name');
    }

    public function getStatisticRow()
    {
        return '<i class="glyphicon glyphicon-comment" title="Сообщений"></i> 0';
    }
}
