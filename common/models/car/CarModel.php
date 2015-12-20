<?php

namespace common\models\car;

use Yii;
use \yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "car_model".
 *
 * @property integer     $id
 * @property string      $name
 * @property integer     $car_firm_id
 * @property string      $date_create
 *
 * @property CarBody[]   $carBodies
 * @property CarFirm     $carFirm
 * @property CarEngine[] $carEngines
 */
class CarModel extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'car_model';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'car_firm_id'], 'required'],
            [['car_firm_id'], 'integer'],
            [['date_create'], 'safe'],
            [['name'], 'string', 'max' => 100]
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
            'car_firm_id' => Yii::t('label', 'Car Firm ID'),
            'date_create' => Yii::t('label', 'Date Create'),
        ];
    }

    /**
     * @inheritdoc
     * @return CarModelQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CarModelQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarBodies()
    {
        return $this->hasMany(CarBody::className(), ['car_model_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarFirm()
    {
        return $this->hasOne(CarFirm::className(), ['id' => 'car_firm_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarEngines()
    {
        return $this->hasMany(CarEngine::className(), ['car_model_id' => 'id']);
    }

    /**
     * @param int $firmId
     *
     * @return array
     */
    public static function getListByFirm($firmId)
    {
        $firmId = (int)$firmId;
        if (empty($firmId)) {
            return [];
        }

        $data = self::find()->where('car_firm_id = ' . $firmId)->all();
        return ArrayHelper::map($data, 'id', 'name');
    }
}
