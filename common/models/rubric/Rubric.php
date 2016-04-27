<?php

namespace common\models\rubric;

use Yii;
use common\components\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "rubric".
 *
 * @property integer $id
 * @property integer $category
 * @property integer $rubric_form
 * @property string  $name
 * @property string  $css_class_background
 * @property string  $image
 * @property string  $date_create
 */
class Rubric extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rubric';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category', 'rubric_form', 'name'], 'required'],
            [['category', 'rubric_form'], 'integer'],
            [['css_class_background', 'image', 'date_create'], 'safe'],
            [['name'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                   => Yii::t('label', 'ID'),
            'category'             => Yii::t('label', 'Category'),
            'rubric_form'          => Yii::t('label', 'Rubric Form'),
            'name'                 => Yii::t('label', 'Name'),
            'css_class_background' => Yii::t('label', 'CSS class'),
            'image'                => Yii::t('label', 'Image'),
            'date_create'          => Yii::t('label', 'Date Create'),
        ];
    }

    /**
     * @inheritdoc
     * @return RubricQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RubricQuery(get_called_class());
    }

    /**
     * @param int|null $category
     *
     * @return array
     */
    public static function getList($category = null)
    {
        if (!empty($category)) {
            $data = self::findAllByCategory($category);
        } else {
            $data = self::find()->all();
        }

        return ArrayHelper::map($data, 'id', 'name');
    }

    /**
     * @param int $category
     *
     * @return array|Rubric[]
     */
    public static function findAllByCategory($category)
    {
        return self::find()->andWhere(['category' => $category])->all();
    }

    /**
     * @return string
     */
    public function getViewName()
    {
        $formView = RubricFormData::getViewName($this->rubric_form);
        return '_forms/' . $formView;
    }

    /**
     * @return string
     */
    public function geFormModelClassName()
    {
        return RubricFormData::geFormModel($this->rubric_form);
    }
}
