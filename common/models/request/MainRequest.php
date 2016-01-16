<?php

namespace common\models\request;

use Yii;
use common\components\ActiveRecord;
use common\models\rubric\Rubric;
use common\models\user\User;
use yii\helpers\Json;

/**
 * This is the model class for table "main_request".
 *
 * @property integer   $id
 * @property integer   $user_id
 * @property integer   $rubric_id
 * @property integer   $status
 * @property string    $date_create
 *
 * @property Rubric    $rubric
 * @property User      $user
 * @property Request[] $requests
 */
class MainRequest extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'main_request';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'rubric_id'], 'required'],
            [['user_id', 'rubric_id', 'status'], 'integer'],
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
            'user_id'     => 'User ID',
            'rubric_id'   => 'Rubric ID',
            'status'      => 'Status',
            'date_create' => 'Date Create',
        ];
    }

    /**
     * @inheritdoc
     * @return MainRequestQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MainRequestQuery(get_called_class());
    }

    /**
     * @param int $rubricId
     *
     * @return bool|int
     */
    public static function create($rubricId)
    {
        $model = new self();
        $model->rubric_id = $rubricId;
        $model->user_id = Yii::$app->user->id;

        return $model->save() ? $model->id : false;
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
    public function getRequests()
    {
        return $this->hasMany(Request::className(), ['main_request_id' => 'id']);
    }
}
