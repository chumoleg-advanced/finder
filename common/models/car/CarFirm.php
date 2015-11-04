<?php

namespace common\models\car;

use Yii;
use \yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "car_firm".
 *
 * @property integer    $id
 * @property string     $name
 * @property integer    $import
 * @property string     $date_create
 *
 * @property CarBody[]  $carBodies
 * @property CarModel[] $carModels
 * @property CarMotor[] $carMotors
 */
class CarFirm extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'car_firm';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['import'], 'integer'],
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
            'import'      => Yii::t('label', 'Import'),
            'date_create' => Yii::t('label', 'Date Create'),
        ];
    }

    /**
     * @inheritdoc
     * @return CarFirmQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CarFirmQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarBodies()
    {
        return $this->hasMany(CarBody::className(), ['car_firm_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarModels()
    {
        return $this->hasMany(CarModel::className(), ['car_firm_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarMotors()
    {
        return $this->hasMany(CarMotor::className(), ['car_firm_id' => 'id']);
    }

    /**
     * @return array
     */
    public function getList()
    {
        $data = $this->find()->all();
        return ArrayHelper::map($data, 'id', 'name');
    }
}
