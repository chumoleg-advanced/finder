<?php

namespace common\models\request;

use common\models\company\Company;
use Yii;
use common\models\rubric\Rubric;
use common\models\user\User;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use common\components\ActiveRecord;
use yii\helpers\Json;

/**
 * This is the model class for table "request".
 *
 * @property integer $id
 * @property integer $rubric_id
 * @property string  $description
 * @property string  $comment
 * @property integer $status
 * @property string  $data
 * @property integer $user_id
 * @property integer $count_view
 * @property integer $count_offer
 * @property string  $date_create
 *
 * @property Rubric  $rubric
 * @property User    $user
 */
class Request extends ActiveRecord
{
    const STATUS_NEW = 1;
    const STATUS_IN_WORK = 3;
    const STATUS_CLOSED = 4;

    public static $statusList
        = [
            self::STATUS_NEW     => 'Новая',
            self::STATUS_IN_WORK => 'В обработке',
            self::STATUS_CLOSED  => 'Закрыта',
        ];

    public $categoryId;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'request';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rubric_id', 'user_id'], 'required'],
            [['rubric_id', 'user_id', 'status', 'count_view', 'count_offer'], 'integer'],
            [['data', 'description', 'comment'], 'string'],
            [['date_create'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'rubric_id'   => 'Рубрика',
            'categoryId'  => 'Категория',
            'description' => 'Описание',
            'comment'     => 'Комментарий',
            'status'      => 'Статус',
            'data'        => 'Data',
            'user_id'     => 'Пользователь',
            'count_view'  => 'Кол-во просмотров',
            'count_offer' => 'Кол-во предложений',
            'date_create' => 'Дата создания',
        ];
    }

    /**
     * @inheritdoc
     * @return RequestQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RequestQuery(get_called_class());
    }

    public function beforeValidate()
    {
        $this->data = Json::encode($this->data);
        return parent::beforeValidate();
    }

    public function afterFind()
    {
        $this->data = Json::decode($this->data);
        return parent::afterFind();
    }

    /**
     * @param $status
     *
     * @return bool
     */
    public function updateStatus($status)
    {
        if (!parent::updateStatus($status)) {
            return false;
        }

        if ($status != self::STATUS_IN_WORK) {
            return true;
        }

        $users = User::getListByRubric($this->rubric_id);
        foreach ($users as $userObj) {
            $companies = $userObj->companies;
            $requestOffer = new RequestOffer();
            $requestOffer->request_id = $this->id;
            $requestOffer->user_id = $userObj->id;
            if (count($companies) == 1) {
                $requestOffer->company_id = $companies[0]->id;
            }

            $requestOffer->save();
        }

        return true;
    }

    /**
     * @param $id
     *
     * @return null|Request
     */
    public static function findById($id)
    {
        return self::find()->whereId($id)->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRubric()
    {
        return $this->hasOne(Rubric::className(), ['id' => 'rubric_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @param $rubricId
     * @param $attributes
     * @param $positions
     *
     * @return bool
     */
    public function createModelFromPost($rubricId, $attributes, $positions)
    {
        try {
            foreach ($positions as $posAttr) {
                $request = new self();
                $request->user_id = Yii::$app->user->id;
                $request->rubric_id = $rubricId;
                $request->description = ArrayHelper::getValue($posAttr, 'description');
                $request->comment = ArrayHelper::getValue($posAttr, 'comment');
                $request->status = self::STATUS_NEW;
                $request->save();

                $requestId = $request->id;

                $posAttr = $this->_saveFiles($posAttr, $requestId);

                unset($posAttr['description']);
                unset($posAttr['comment']);
                $request->data = $attributes + $posAttr;
                $request->save();
            }

            return true;

        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param array $posAttr
     * @param int   $requestId
     *
     * @return array
     */
    private function _saveFiles($posAttr, $requestId)
    {
        if (empty($posAttr['image'])) {
            return $posAttr;
        }

        /** @var \yii\web\UploadedFile $fileObj */
        foreach ($posAttr['image'] as &$fileObj) {
            $dir = 'uploads/' . $requestId;
            if (!is_dir($dir)) {
                mkdir($dir);
            }

            $fileName = $dir . '/' . md5($fileObj->name . '_' . mktime());

            $fileObj->saveAs($fileName);
            $fileObj = $fileName;
        }
        unset($fileObj);

        return $posAttr;
    }
}
