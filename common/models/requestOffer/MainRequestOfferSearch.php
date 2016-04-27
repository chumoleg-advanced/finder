<?php

namespace common\models\requestOffer;

use common\helpers\CategoryHelper;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use common\models\message\Message;
use yii\helpers\Url;

class MainRequestOfferSearch extends MainRequestOffer
{
    public $category;
    public $rubricId;
    public $description;
    public $countRequestOffers;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['request_id', 'status', 'category', 'rubricId'], 'integer'],
            [['date_create', 'description'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'category'  => 'Категория',
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
        $query->joinWith('request.rubric');
        $query->select([
            'main_request_offer.*',
            '(SELECT COUNT(t.id) FROM ' . RequestOffer::tableName() . ' t
                WHERE t.main_request_offer_id = main_request_offer.id) AS countRequestOffers'
        ]);

        $dataProvider = $this->getDataProvider($query, ['status' => SORT_ASC, 'request_id' => SORT_DESC]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'main_request_offer.id'                => $this->id,
            'main_request_offer.status'            => $this->status,
            'main_request_offer.request_id'        => $this->request_id,
            'request.rubric_id'                    => $this->rubricId,
            'request.category'                     => $this->category,
            'DATE(main_request_offer.date_create)' => $this->date_create
        ]);

        $query->andFilterWhere(['like', 'request.description', $this->description]);

        $this->andWhereUser($query, 'main_request_offer.user_id');

        return $dataProvider;
    }

    /**
     * @return array
     */
    public function getListCategories()
    {
        $query = self::find()->joinWith('request')->distinct('request.category');
        $this->andWhereUser($query, 'main_request_offer.user_id');
        $data = ArrayHelper::map($query->all(), 'request.category', 'request.category');

        return CategoryHelper::getListByIds($data);
    }

    /**
     * @return array
     */
    public function getListRubrics()
    {
        $query = self::find()->joinWith('request.rubric')->distinct('rubric.id');
        $this->andWhereUser($query, 'main_request_offer.user_id');

        return ArrayHelper::map($query->all(), 'request.rubric_id', 'request.rubric.name');
    }

    /**
     * @return string
     */
    public function getStatisticRow()
    {
        $countMessages = Message::getCountByMainRequestOffer($this->id);
        $html = Html::a('<i class="glyphicon glyphicon-certificate" title="Моих Предложений"></i>',
                Url::to('offer?id=' . $this->id)) . ' ' . $this->countRequestOffers;

        $html .= Html::a('<i class="glyphicon glyphicon-comment marginIcon" title="Сообщений"></i>', 'javascript:;', [
                'class'           => 'rowRequestMessage',
                'data-main-offer' => $this->id
            ]) . ' ' . $countMessages;

        return $html;
    }
}
