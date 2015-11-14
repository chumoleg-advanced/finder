<?php

namespace common\models\car;

use Yii;
use \yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "car_engine".
 *
 * @property integer  $id
 * @property string   $name
 * @property integer  $car_firm_id
 * @property integer  $car_model_id
 * @property integer  $car_body_id
 * @property string   $date_create
 *
 * @property CarBody  $carBody
 * @property CarFirm  $carFirm
 * @property CarModel $carModel
 */
class CarEngine extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'car_engine';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'car_firm_id', 'car_model_id', 'car_body_id'], 'required'],
            [['car_firm_id', 'car_model_id', 'car_body_id'], 'integer'],
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
            'id'           => Yii::t('label', 'ID'),
            'name'         => Yii::t('label', 'Name'),
            'car_firm_id'  => Yii::t('label', 'Car Firm ID'),
            'car_model_id' => Yii::t('label', 'Car Model ID'),
            'car_body_id'  => Yii::t('label', 'Car Body ID'),
            'date_create'  => Yii::t('label', 'Date Create'),
        ];
    }

    /**
     * @inheritdoc
     * @return CarEngineQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CarEngineQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarBody()
    {
        return $this->hasOne(CarBody::className(), ['id' => 'car_body_id']);
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
    public function getCarModel()
    {
        return $this->hasOne(CarModel::className(), ['id' => 'car_model_id']);
    }

    /**
     * @param int $bodyId
     *
     * @return array
     */
    public function getListByBody($bodyId)
    {
        $bodyId = (int)$bodyId;
        if (empty($bodyId)) {
            return [];
        }

        $data = $this->find()->where('car_body_id = ' . $bodyId)->all();
        return ArrayHelper::map($data, 'id', 'name');
    }
}
