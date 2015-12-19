<?php

namespace common\models\category;

use Yii;
use \yii\db\ActiveRecord;
use common\models\rubric\Rubric;

/**
 * This is the model class for table "category".
 *
 * @property integer  $id
 * @property string   $name
 * @property string   $date_create
 *
 * @property Rubric[] $rubrics
 */
class Category extends ActiveRecord
{
    const COUNT_ON_MAIN_PAGE = 9;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['date_create'], 'safe'],
            [['name'], 'string', 'max' => 200]
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
            'date_create' => Yii::t('label', 'Date Create'),
        ];
    }

    /**
     * @inheritdoc
     * @return CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }

    /**
     * @return Rubric[]
     */
    public function getRubrics()
    {
        return $this->hasMany(Rubric::className(), ['category_id' => 'id']);
    }

    /**
     * @return array|Category[]
     */
    public static function getList()
    {
        return self::find()->with('rubrics')->all();
    }
}
