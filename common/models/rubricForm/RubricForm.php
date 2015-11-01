<?php

namespace common\models\rubricForm;

use Yii;
use \yii\db\ActiveRecord;
use common\models\rubric\Rubric;

/**
 * This is the model class for table "rubric_form".
 *
 * @property integer  $id
 * @property string   $name_view
 * @property string   $date_create
 *
 * @property Rubric[] $rubrics
 */
class RubricForm extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rubric_form';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_view'], 'required'],
            [['date_create'], 'safe'],
            [['name_view'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('label', 'ID'),
            'name_view'   => Yii::t('label', 'Name View'),
            'date_create' => Yii::t('label', 'Date Create'),
        ];
    }

    /**
     * @inheritdoc
     * @return RubricFormQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RubricFormQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRubrics()
    {
        return $this->hasMany(Rubric::className(), ['rubric_form_id' => 'id']);
    }
}
