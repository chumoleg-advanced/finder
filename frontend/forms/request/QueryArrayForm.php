<?php

namespace frontend\forms\request;

use Yii;
use yii\base\Model;

class QueryArrayForm extends Model
{
    public $description;
    public $comment;
    public $image = [];
    public $partsCondition = [];
    public $partsOriginal = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'required'],
            [['partsCondition'], 'required', 'on' => 'parts'],
            [['image'], 'safe'],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, jpeg, gif, png', 'maxFiles' => 5],
            [['comment', 'partsOriginal', 'partsCondition'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return (new BaseForm())->attributeLabels();
    }

    public function beforeValidate()
    {
        $this->_checkOriginal();

        return parent::beforeValidate();
    }

    private function _checkOriginal()
    {
        if ($this->scenario != 'parts' || empty($this->partsCondition)) {
            return;
        }

        if (in_array(1, $this->partsCondition) && empty($this->partsOriginal)) {
            $this->addError('partsOriginal', 'Необходимо заполнить «Оригинальность».');
        }
    }
}