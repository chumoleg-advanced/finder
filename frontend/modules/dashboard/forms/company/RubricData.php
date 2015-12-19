<?php

namespace app\modules\dashboard\forms\company;

use yii\base\Model;

class RubricData extends Model
{
	public $value;
    public $type;

    /**
    * @inheritdoc
    */
    public function rules()
    {
        return [
            [['value', 'type'], 'safe']
        ];
    }
}
