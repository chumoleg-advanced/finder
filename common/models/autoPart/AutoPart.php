<?php

namespace common\models\autoPart;

use Yii;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "auto_part".
 *
 * @property integer $id
 * @property string  $name
 * @property string  $date_create
 */
class AutoPart extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auto_part';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_create'], 'safe'],
            [['name'], 'string', 'max' => 150]
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
     * @return AutoPartQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AutoPartQuery(get_called_class());
    }
}
