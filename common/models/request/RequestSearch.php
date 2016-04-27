<?php

namespace common\models\request;

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
        $countMessages = Message::getCountByRequest($this->id);
        $html = '<div class="indicat"><i class="fa fa-circle point1" title="Просмотров"></i> Просмотров' . ' <span>' . $this->count_view . '</span></div>';
        $html .= '<div class="indicat">';
        $html .= Html::a('<i class="fa fa-circle point2" title="Предложений"></i> Предложений',
                Url::to('view/' . $this->id . '#bestRequestOffer')) . ' <span>' . $this->countRequestOffers . '</span>';
        $html .= '</div>';

        $messageLink = '<div class="indicat"><i class="fa fa-circle point3" title="Сообщений"></i> Сообщений';
        if ($countMessages > 0) {
            $messageLink = Html::a($messageLink, 'javascript:;', [
                'class'       => 'messageButton',
                'data-search' => '№' . $this->id
            ]);
        }

        $html .= $messageLink . ' <span>' . $countMessages . '</span></div>';

        return $html;
    }
}
