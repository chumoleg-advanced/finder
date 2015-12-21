<?php

namespace common\models\company;

use common\components\activeQueryTraits\CommonQueryTrait;
use common\components\activeQueryTraits\UserQueryTrait;

/**
 * This is the ActiveQuery class for [[Company]].
 *
 * @see Company
 */
class CompanyQuery extends \yii\db\ActiveQuery
{
    use CommonQueryTrait,
        UserQueryTrait;
}