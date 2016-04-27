<?php

namespace common\models\request;

use common\helpers\CategoryHelper;
use common\models\message\Message;
use common\models\requestOffer\RequestOffer;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

class RequestSearch extends Request
{
    public $countRequestOffers;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'category', 'rubric_id', 'user_id'], 'integer'],
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
        $query->select([
            'request.*',
            '(SELECT COUNT(t.id) FROM ' . RequestOffer::tableName() . ' t
                WHERE t.request_id = request.id) AS countRequestOffers'
        ]);

        $dataProvider = $this->getDataProvider($query);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'request.id'                => $this->id,
            'request.status'            => $this->status,
            'request.category'          => $this->category,
            'request.rubric_id'         => $this->rubric_id,
            'request.user_id'           => $this->user_id,
            'DATE(request.date_create)' => $this->date_create
        ]);

        $query->andFilterWhere(['like', 'description', $this->description]);
        $this->andWhereUser($query, 'request.user_id');

        return $dataProvider;
    }

    /**
     * @return array
     */
    public function getUserList()
    {
        return ArrayHelper::map(self::find()->joinWith('user')->distinct('user_id')->all(),
            'user.id', 'user.email');
    }

    /**
     * @return array
     */
    public function getCategoryList()
    {
        $query = self::find()->distinct('category');
        $this->andWhereUser($query, 'user_id');
        $data = ArrayHelper::map($query->all(), 'category', 'category');

        return CategoryHelper::getListByIds($data);
    }

    /**
     * @return array
     */
    public function getRubricList()
    {
        $query = self::find()->joinWith('rubric')->distinct('rubric_id');
        $this->andWhereUser($query, 'request.user_id');

        return ArrayHelper::map($query->all(), 'rubric.id', 'rubric.name');
    }

    /**
     * @return string
     */
    public function getStatisticRow()
    {
        $countMessages = Message::getCountByRequest($this->id);
        $html = '<i class="glyphicon glyphicon-eye-open" title="Просмотров"></i>' . ' ' . $this->count_view;
        $html .= Html::a('<i class="glyphicon glyphicon-certificate marginIcon" title="Предложений"></i>',
                Url::to('view/' . $this->id . '#bestRequestOffer')) . ' ' . $this->countRequestOffers;

        $messageLink = '<i class="glyphicon glyphicon-comment marginIcon" title="Сообщений"></i>';
        if ($countMessages > 0) {
            $messageLink = Html::a($messageLink, 'javascript:;', [
                'class'       => 'messageButton',
                'data-search' => '№' . $this->id
            ]);
        }

        $html .= $messageLink . ' ' . $countMessages;

        return $html;
    }
}
