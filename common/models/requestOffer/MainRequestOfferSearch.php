<?php

namespace common\models\requestOffer;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use common\models\request\Request;

class MainRequestOfferSearch extends MainRequestOffer
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
            [['request_id', 'status', 'categoryId', 'rubricId'], 'integer'],
            [['date_create', 'description'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'categoryId'  => 'Категория',
            'rubricId'    => 'Рубрика',
            'description' => 'Описание',
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
                'main_request_offer.status' => [
                    self::STATUS_NEW,
                    self::STATUS_ACTIVE,
                ]
            ]);
        } else {
            $query->andWhere(['<>', 'request.status', Request::STATUS_CLOSED]);
        }

        $query->andFilterWhere([
            'main_request_offer.id'                => $this->id,
            'main_request_offer.status'            => $this->status,
            'main_request_offer.request_id'        => $this->request_id,
            'request.rubric_id'                    => $this->rubricId,
            'rubric.category_id'                   => $this->categoryId,
            'DATE(main_request_offer.date_create)' => $this->date_create
        ]);

        $query->andFilterWhere(['like', 'request.description', $this->description]);

        if (Yii::$app->user->can('accessToPersonalCabinet')) {
            $query->andWhere(['main_request_offer.user_id' => Yii::$app->user->id]);
        }

        return $dataProvider;
    }

    public function getListCategories()
    {
        $data = self::find()
            ->joinWith('request.rubric.category')
            ->distinct('rubric.category_id')
            ->andWhere(['main_request_offer.user_id' => Yii::$app->user->id])
            ->all();

        return ArrayHelper::map($data, 'request.rubric.category_id', 'request.rubric.category.name');
    }

    public function getListRubrics()
    {
        $data = self::find()
            ->joinWith('request.rubric')
            ->distinct('rubric.id')
            ->andWhere(['main_request_offer.user_id' => Yii::$app->user->id])
            ->all();

        return ArrayHelper::map($data, 'request.rubric_id', 'request.rubric.name');
    }

    public function getStatisticRow()
    {
        return '<i class="glyphicon glyphicon-comment" title="Сообщений"></i> 0';
    }
}
