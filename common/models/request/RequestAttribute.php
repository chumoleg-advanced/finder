<?php

namespace common\models\request;

use common\components\ActiveRecord;
use common\components\CarData;
use common\models\car\CarBody;
use common\models\car\CarEngine;
use common\models\car\CarFirm;
use common\models\car\CarModel;
use common\models\manufacturer\Manufacturer;
use common\models\wheelParam\WheelParam;
use Yii;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\base\Model;

/**
 * This is the model class for table "request_attribute".
 *
 * @property integer $id
 * @property integer $request_id
 * @property string  $attribute_name
 * @property string  $value
 *
 * @property Request $request
 */
class RequestAttribute extends ActiveRecord
{
    const GROUP_CAR = 1;
    const GROUP_WHEEL = 2;
    const GROUP_PART = 3;
    const GROUP_PRICE = 4;
    const GROUP_DELIVERY = 5;

    /**
     * @param array $requestAttributes
     * @param Model $formModel
     * @param int   $group
     *
     * @return array
     */
    public static function getValuesByGroup($requestAttributes, $formModel, $group)
    {
        $groups = [
            self::GROUP_CAR      => [
                'carFirm',
                'carModel',
                'carBody',
                'carEngine',
                'color',
                'vinNumber',
                'yearRelease',
                'drive',
                'transmission',
            ],
            self::GROUP_PRICE    => [
                'priceFrom',
                'priceTo'
            ],
            self::GROUP_WHEEL    => [
                'discType',
                'tireType',
                'tireTypeWinter',
                'manufacturer',
                'diameter',
                'points',
                'out',
                'width',
                'height',
                'count',
            ],
            self::GROUP_PART     => [
                'partsCondition',
                'partsOriginal',
            ],
            self::GROUP_DELIVERY => [
                'deliveryAddress',
                'addressCoordinates'
            ]
        ];

        $attributes = ArrayHelper::getValue($groups, $group);
        $labels = $formModel->attributeLabels();

        $array = [];
        foreach ($attributes as $name) {
            if (!isset($requestAttributes[$name])) {
                continue;
            }

            $label = ArrayHelper::getValue($labels, $name);
            if ($group == self::GROUP_DELIVERY) {
                $label = $name;
            }

            $value = self::getValueForDetail($name, $requestAttributes[$name]);
            if (is_array($value)) {
                $array[$label] = implode(',<br />', $value);
            } else {
                $array[$label] = $value;
            }
        }

        return $array;
    }

    public static function getValueForDetail($attributeName, $value)
    {
        $attributes = [
            'carFirm'        => CarFirm::className(),
            'carModel'       => CarModel::className(),
            'carBody'        => CarBody::className(),
            'carEngine'      => CarEngine::className(),
            'diameter'       => WheelParam::className(),
            'points'         => WheelParam::className(),
            'width'          => WheelParam::className(),
            'out'            => WheelParam::className(),
            'height'         => WheelParam::className(),
            'manufacturer'   => Manufacturer::className(),
            'drive'          => CarData::$driveList,
            'transmission'   => CarData::$transmissionList,
            'partsCondition' => CarData::$partsCondition,
            'partsOriginal'  => CarData::$partsOriginal,
            'discType'       => CarData::$discTypeList,
            'tireType'       => CarData::$tireTypeList,
            'tireTypeWinter' => CarData::$tireTypeWinterList,
        ];

        if (isset($attributes[$attributeName])) {
            $modelByAttribute = $attributes[$attributeName];
            if (is_array($modelByAttribute)) {
                if (is_array($value)) {
                    $newArray = [];
                    foreach ($value as $val) {
                        $newArray[$val] = ArrayHelper::getValue($modelByAttribute, $val);
                    }

                    return $newArray;

                } else {
                    return ArrayHelper::getValue($modelByAttribute, $value);
                }

            } else {
                try {
                    if (is_array($value)) {
                        $newArray = [];
                        foreach ($value as $val) {
                            $newArray[$val] = $modelByAttribute::getNameById($val);
                        }

                        return $newArray;

                    } else {
                        return $modelByAttribute::getNameById($value);
                    }
                } catch (Exception $e) {
                }
            }
        }

        return $value;
    }

    /**
     * @param int   $requestId
     * @param array $attributesData
     */
    public static function create($requestId, $attributesData)
    {
        if (empty($attributesData) || empty($requestId)) {
            return;
        }

        foreach ($attributesData as $name => $value) {
            if (is_null($value)
                || (is_array($value) && empty($value))
                || (is_string($value) && $value == '')
            ) {
                continue;
            }

            $model = new self();
            $model->request_id = $requestId;
            $model->attribute_name = $name;
            $model->value = $value;
            $model->save();
        }
    }

    /**
     * @param $requestId
     * @param $name
     *
     * @return mixed
     */
    public static function getValueByRequest($requestId, $name)
    {
        if (empty($requestId) || empty($name)) {
            return null;
        }

        $data = self::find()
            ->andWhere(['request_id' => $requestId])
            ->andWhere(['attribute_name' => $name])
            ->one();

        return self::getValueForDetail($name, $data->value);
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['dateCreate']);

        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'request_attribute';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['request_id', 'attribute_name'], 'required'],
            [['request_id'], 'integer'],
            [['value'], 'string'],
            [['attribute_name'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'             => 'ID',
            'request_id'     => 'Request ID',
            'attribute_name' => 'Attribute Name',
            'value'          => 'Value',
        ];
    }

    public function beforeValidate()
    {
        $this->value = Json::encode($this->value);
        return parent::beforeValidate();
    }

    public function afterFind()
    {
        $this->value = Json::decode($this->value);
        return parent::afterFind();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequest()
    {
        return $this->hasOne(Request::className(), ['id' => 'request_id']);
    }
}
