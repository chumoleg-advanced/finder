<?php

namespace common\models\wheelParam;

use Yii;
use common\components\ActiveRecord;
use yii\helpers\ArrayHelper;

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
    const TIRE_WIDTH = 1;
    const TIRE_HEIGHT = 2;
    const DISC_DIAMETER = 3;
    const DISC_POINTS = 4;
    const DISC_WIDTH = 5;
    const DISC_OUT = 6;

    /**
     * @param int $type
     *
     * @return array
     */
    public static function getListParams($type)
    {
        $data = (new self())->find()->whereType($type)->all();
        return ArrayHelper::map($data, 'id', 'value');
    }

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
