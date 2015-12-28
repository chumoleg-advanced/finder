<?php

namespace common\models\request;

use common\components\activeQueryTraits\CommonQueryTrait;

/**
 * This is the ActiveQuery class for [[Request]].
 *
 * @see Request
 */
class RequestQuery extends \yii\db\ActiveQuery
{
    use CommonQueryTrait;
}