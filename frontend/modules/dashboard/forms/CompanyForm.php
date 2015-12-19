<?php

namespace app\modules\dashboard\forms;

use Yii;
use yii\base\Model;

class CompanyForm extends Model
{
    public $userId;
    public $name;
    public $alias;
    public $inn;

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('module/labels', 'Name'),
            'inn'  => Yii::t('module/labels', 'Inn')
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'inn'], 'filter', 'filter' => 'trim'],
            [['name', 'userId'], 'required'],
//            ['name', 'unique', 'targetAttribute' => ['name', 'inn']],
            [['name', 'alias'], 'string', 'max' => 150],
            ['inn', 'string', 'max' => 13],
            ['inn', 'double'],
            ['userId', 'integer', 'integerOnly' => true],
        ];
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        if (empty($this->userId)) {
            $this->userId = Yii::$app->user->id;
        }

        if (empty($this->alias)) {
            $this->alias = 'none';
        }

        return parent::beforeValidate();
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function createCompany()
    {
        if (!$this->validate()) {
            return false;
        }

        /** @var \common\services\registry\RegistryService $factory */
        $factory = Yii::$container->get('common\services\registry\RegistryServiceInterface');
        if (!$factory->createCompany($this->userId, $this->name, $this->alias, $this->inn)) {
            throw new \Exception();
        }

        return true;
    }
}
