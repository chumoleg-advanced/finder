<?php

namespace common\models\wheelParam;

use Yii;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "wheel_param".
 *
 * @property integer $id
 * @property integer $type
 * @property string  $value
 * @property string  $date_create
 */
class WheelParam extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wheel_param';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'value'], 'required'],
            [['type'], 'integer'],
            [['date_create'], 'safe'],
            [['value'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('label', 'ID'),
            'type'        => Yii::t('label', 'Type'),
            'value'       => Yii::t('label', 'Value'),
            'date_create' => Yii::t('label', 'Date Create'),
        ];
    }

    /**
     * @inheritdoc
     * @return WheelParamQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WheelParamQuery(get_called_class());
    }
}
