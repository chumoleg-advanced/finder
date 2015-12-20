<?php

namespace common\models;

use Yii;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "dictionary".
 *
 * @property integer $id
 * @property string  $name
 */
class Dictionary extends ActiveRecord
{
    /**
     * @return string
     */
    public static function getRandWord()
    {
        return self::getDb()->createCommand('SELECT name FROM ' . self::tableName() . ' AS r1
            JOIN (SELECT CEIL(RAND() * (SELECT MAX(id) FROM ' . self::tableName() . ')) AS id) AS r2
            WHERE r1.id >= r2.id ORDER BY r1.id ASC LIMIT 1')->queryScalar();
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dictionary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 15]
        ];
    }
}
