<?php

namespace common\models\manufacturer;

use Yii;
use common\components\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "manufacturer".
 *
 * @property integer $id
 * @property string  $name
 * @property integer $type
 * @property string  $date_create
 */
class Manufacturer extends ActiveRecord
{
    const TYPE_TIRE = 1;
    const TYPE_DISC = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'manufacturer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type'], 'integer'],
            [['date_create'], 'safe'],
            [['name'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('label', 'ID'),
            'name'        => Yii::t('label', 'Name'),
            'type'        => Yii::t('label', 'Type'),
            'date_create' => Yii::t('label', 'Date Create'),
        ];
    }

    /**
     * @inheritdoc
     * @return ManufacturerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ManufacturerQuery(get_called_class());
    }

    /**
     * @param int $type
     *
     * @return array
     */
    public static function getListByType($type)
    {
        $data = self::find()->whereType($type)->all();
        return ArrayHelper::map($data, 'id', 'name');
    }
}
