<?php

namespace common\models\car;

use Yii;
use common\components\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "car_body".
 *
 * @property integer     $id
 * @property string      $name
 * @property integer     $car_firm_id
 * @property integer     $car_model_id
 * @property string      $date_create
 *
 * @property CarModel    $carModel
 * @property CarFirm     $carFirm
 * @property CarEngine[] $carEngines
 */
class CarBody extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'car_body';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'car_firm_id', 'car_model_id'], 'required'],
            [['car_firm_id', 'car_model_id'], 'integer'],
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
            'date_create'  => Yii::t('label', 'Date Create'),
        ];
    }

    /**
     * @inheritdoc
     * @return CarBodyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CarBodyQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarModel()
    {
        return $this->hasOne(CarModel::className(), ['id' => 'car_model_id']);
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
        return $this->hasMany(CarEngine::className(), ['car_body_id' => 'id']);
    }

    /**
     * @param int $modelId
     *
     * @return array
     */
    public static function getListByModel($modelId)
    {
        $modelId = (int)$modelId;
        if (empty($modelId)) {
            return [];
        }

        $data = self::find()->andWhere('car_model_id = ' . $modelId)->all();
        return ArrayHelper::map($data, 'id', 'name');
    }
}
