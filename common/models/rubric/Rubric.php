<?php

namespace common\models\rubric;

use Yii;
use \yii\db\ActiveRecord;
use common\models\category\Category;
use common\models\rubricForm\RubricForm;

/**
 * This is the model class for table "rubric".
 *
 * @property integer    $id
 * @property integer    $category_id
 * @property integer    $rubric_form_id
 * @property string     $name
 * @property string     $date_create
 *
 * @property Category   $category
 * @property RubricForm $rubricForm
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
            [['category_id', 'rubric_form_id', 'name'], 'required'],
            [['category_idm', 'rubric_form_id'], 'integer'],
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
            'id'             => Yii::t('label', 'ID'),
            'category_id'    => Yii::t('label', 'Category ID'),
            'rubric_form_id' => Yii::t('label', 'Rubric Form ID'),
            'name'           => Yii::t('label', 'Name'),
            'date_create'    => Yii::t('label', 'Date Create'),
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
     * @return \yii\db\ActiveQuery
     */
    public function getRubricForm()
    {
        return $this->hasOne(RubricForm::className(), ['id' => 'rubric_form_id']);
    }
}
