<?php

namespace common\models\request;

use common\components\Json;
use Yii;
use common\models\rubric\Rubric;
use common\models\user\User;
use yii\base\Exception;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "request".
 *
 * @property integer           $id
 * @property integer           $rubric_id
 * @property string            $data
 * @property integer           $user_id
 * @property string            $date_create
 *
 * @property Rubric            $rubric
 * @property User              $user
 * @property RequestPosition[] $requestPositions
 */
class Request extends \yii\db\ActiveRecord
{
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
            [['rubric_id', 'user_id'], 'integer'],
            [['data'], 'string'],
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
            'rubric_id'   => 'Rubric ID',
            'data'        => 'Data',
            'user_id'     => 'User ID',
            'date_create' => 'Date Create',
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
        $this->data = \yii\helpers\Json::encode($this->data);
        return parent::beforeValidate();
    }

    public function afterFind()
    {
        $this->data = \yii\helpers\Json::decode($this->data);
        return parent::afterFind();
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
    public function getRequestPositions()
    {
        return $this->hasMany(RequestPosition::className(), ['request_id' => 'id']);
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
            if (!$requestId = $this->_createNewRequest($rubricId, $attributes)) {
                return false;
            }

            $this->_savePositions($positions, $requestId);
            return true;

        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param $rubricId
     * @param $attributes
     *
     * @return int
     */
    private function _createNewRequest($rubricId, $attributes)
    {
        $request = new self();
        $request->user_id = Yii::$app->user->id;
        $request->rubric_id = $rubricId;
        $request->data = $attributes;
        $request->save();

        $requestId = $request->id;
        return $requestId;
    }

    /**
     * @param $positions
     * @param $requestId
     *
     * @return \yii\web\UploadedFile
     */
    private function _savePositions($positions, $requestId)
    {
        foreach ($positions as $posAttr) {
            if (!empty($posAttr['image'])) {
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
            }

            $this->_savePositionRow($requestId, $posAttr);
        }
    }

    /**
     * @param $requestId
     * @param $posAttr
     */
    private function _savePositionRow($requestId, $posAttr)
    {
        $rel = new RequestPosition();
        $rel->request_id = $requestId;
        $rel->description = ArrayHelper::getValue($posAttr, 'description');
        $rel->comment = ArrayHelper::getValue($posAttr, 'comment');

        unset($posAttr['description']);
        unset($posAttr['comment']);

        $rel->data = $posAttr;
        $rel->save();
    }
}
