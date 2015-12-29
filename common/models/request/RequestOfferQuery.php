<?php

namespace common\models\request;

use common\components\activeQueryTraits\CommonQueryTrait;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[RequestOffer]].
 *
 * @see RequestOffer
 */
class RequestOfferQuery extends ActiveQuery
{
    use CommonQueryTrait;
}