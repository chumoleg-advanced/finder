<?php

namespace app\modules\dashboard\forms\company;

use yii\base\Model;

class ContactData extends Model
{
    public $street_address;
    public $locality;
    public $region;
    public $postal_code;

    /**
    * @inheritdoc
    */
    public function rules()
    {
        return [
            [['street_address', 'locality', 'region', 'postal_code'], 'safe']
        ];
    }
}
