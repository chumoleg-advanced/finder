<?php

namespace common\models\rubric;

use Yii;
use \yii\db\ActiveRecord;
use common\models\category\Category;
use \yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "rubric".
 *
 * @property integer  $id
 * @property integer  $category_id
 * @property integer  $rubric_form
 * @property string   $name
 * @property string   $date_create
 *
 * @property Category $category
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
            [['category_id', 'rubric_form', 'name'], 'required'],
            [['category_idm', 'rubric_form'], 'integer'],
            [['date_create'], 'safe'],
            [['name'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('label', 'ID'),
            'category_id' => Yii::t('label', 'Category ID'),
            'rubric_form' => Yii::t('label', 'Rubric Form'),
            'name'        => Yii::t('label', 'Name'),
            'date_create' => Yii::t('label', 'Date Create'),
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
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
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

    /**
     * @param int $id
     *
     * @return Rubric|null
     */
    public static function findById($id)
    {
        return self::find()->whereId($id)->one();
    }

    /**
     * @param int $categoryId
     *
     * @return array|Rubric[]
     */
    public static function findAllByCategory($categoryId)
    {
        return self::find()->whereCategoryId($categoryId)->all();
    }

    /**
     * @param int $categoryId
     *
     * @return array
     */
    public static function getListByCategory($categoryId)
    {
        $data = self::findAllByCategory($categoryId);
        return ArrayHelper::map($data, 'id', 'name');
    }
}
