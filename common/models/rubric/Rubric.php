<?php

namespace common\models\rubric;

use Yii;
use common\models\category\Category;

/**
 * This is the model class for table "rubric".
 *
 * @property string   $id
 * @property string   $category_id
 * @property string   $name
 * @property string   $date_create
 *
 * @property Category $category
 */
class Rubric extends \yii\db\ActiveRecord
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
            [['category_id', 'name'], 'required'],
            [['category_id'], 'integer'],
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
            'name'        => Yii::t('label', 'Name'),
            'date_create' => Yii::t('label', 'Date Create'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @inheritdoc
     * @return RubricQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RubricQuery(get_called_class());
    }
}
