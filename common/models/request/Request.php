<?php

namespace common\models\request;

use Imagine\Image\ManipulatorInterface;
use Yii;
use common\models\rubric\Rubric;
use common\models\user\User;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use common\components\ActiveRecord;
use yii\imagine\Image;

/**
 * This is the model class for table "request".
 *
 * @property integer            $id
 * @property integer            $main_request_id
 * @property string             $id_for_client
 * @property integer            $rubric_id
 * @property string             $description
 * @property string             $comment
 * @property integer            $status
 * @property integer            $user_id
 * @property integer            $count_view
 * @property string             $date_create
 *
 * @property MainRequest        $mainRequest
 * @property Rubric             $rubric
 * @property User               $user
 * @property RequestAttribute[] $requestAttributes
 * @property RequestImage[]     $requestImages
 * @property RequestOffer[]     $requestOffers
 * @property RequestView[]      $requestViews
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
            [['main_request_id', 'id_for_client', 'rubric_id', 'user_id'], 'required'],
            [['main_request_id', 'rubric_id', 'user_id', 'status', 'count_view'], 'integer'],
            [['description', 'comment'], 'string'],
            [['date_create'], 'safe'],
            [['id_for_client'], 'string', 'max' => 15],
            [['id_for_client'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'              => 'ID',
            'main_request_id' => 'Main Request ID',
            'id_for_client'   => 'Номер',
            'rubric_id'       => 'Рубрика',
            'categoryId'      => 'Категория',
            'description'     => 'Описание',
            'comment'         => 'Комментарий',
            'status'          => 'Статус',
            'user_id'         => 'Пользователь',
            'count_view'      => 'Кол-во просмотров',
            'date_create'     => 'Дата создания',
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

        $this->_createRequestOffers();

        return true;
    }

    private function _createRequestOffers()
    {
        if ($this->status != self::STATUS_IN_WORK) {
            return;
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
    public function getMainRequest()
    {
        return $this->hasOne(MainRequest::className(), ['id' => 'main_request_id']);
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
     * @return \yii\db\ActiveQuery
     */
    public function getRequestOffers()
    {
        return $this->hasMany(RequestOffer::className(), ['request_id' => 'id'])
            ->andWhere(['status' => RequestOffer::STATUS_ACTIVE]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequestImages()
    {
        return $this->hasMany(RequestImage::className(), ['request_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequestViews()
    {
        return $this->hasMany(RequestView::className(), ['request_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequestAttributes()
    {
        return $this->hasMany(RequestAttribute::className(), ['request_id' => 'id']);
    }

    /**
     * @param $rubricId
     * @param $commonAttributes
     * @param $positions
     *
     * @return bool
     */
    public function createModelFromPost($rubricId, $commonAttributes, $positions)
    {
//        try {
        if (!$mainRequestId = MainRequest::create($rubricId)) {
            return false;
        }

        foreach ($positions as $k => $positionAttr) {
            $request = new self();
            $request->main_request_id = $mainRequestId;
            $request->id_for_client = $mainRequestId . '-' . ($k + 1);
            $request->user_id = Yii::$app->user->id;
            $request->rubric_id = $rubricId;
            $request->description = ArrayHelper::getValue($positionAttr, 'description');
            $request->comment = ArrayHelper::getValue($positionAttr, 'comment');
            $request->status = self::STATUS_NEW;
            $request->save();

            $this->_saveFiles($positionAttr, $request->id);

            unset($positionAttr['description']);
            unset($positionAttr['comment']);
            unset($positionAttr['image']);

            RequestAttribute::create($request->id, ArrayHelper::merge($commonAttributes, $positionAttr));
        }

        return true;

//        } catch (Exception $e) {
//            return false;
//        }
    }

    /**
     * @param array $posAttr
     * @param int   $requestId
     */
    private function _saveFiles($posAttr, $requestId)
    {
        if (empty($posAttr['image'])) {
            return;
        }

        /** @var \yii\web\UploadedFile $fileObj */
        foreach ($posAttr['image'] as $fileObj) {
            try {
                $dir = 'uploads/' . $requestId;
                if (!is_dir($dir)) {
                    mkdir($dir);
                }

                $baseName = md5($fileObj->name . '_' . mktime()) . '.' . $fileObj->extension;
                $fileName = $dir . '/' . $baseName;
                if (!$fileObj->saveAs($fileName)) {
                    continue;
                }

                Image::thumbnail($fileName, 1000, 1000, ManipulatorInterface::THUMBNAIL_INSET)->save($fileName);

                $thumbName = $dir . '/thumb_' . $baseName;
                Image::thumbnail($fileName, 200, 200, ManipulatorInterface::THUMBNAIL_INSET)->save($thumbName);

                $img = new RequestImage();
                $img->request_id = $requestId;
                $img->name = $fileName;
                $img->thumb_name = $thumbName;
                $img->save();

            } catch (Exception $e) {
                continue;
            }
        }
    }

    /**
     * @return array
     */
    public function getRequestAttributesData()
    {
        $array = [];
        foreach ($this->requestAttributes as $obj) {
            $array[$obj->attribute_name] = $obj->value;
        }

        return $array;
    }
}
