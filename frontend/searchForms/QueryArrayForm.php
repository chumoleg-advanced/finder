<?php

namespace frontend\searchForms;

use Yii;
use yii\base\Model;

class QueryArrayForm extends Model
{
    public $description;
    public $comment;
    public $image = [];
    public $condition = [];
    public $original = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'required'],
            [['condition'], 'required', 'on' => 'parts'],
            [['image'], 'safe'],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, jpeg, gif, png', 'maxFiles' => 5],
            [['comment', 'original', 'condition'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'description' => 'Описание',
            'comment'     => 'Комментарий',
            'image'       => 'Фото',
            'condition'   => 'Состояние',
            'original'    => 'Оригинальность',
        ];
    }

    public function beforeValidate()
    {
        $this->_checkOriginal();

        return parent::beforeValidate();
    }

    private function _checkOriginal()
    {
        if ($this->scenario != 'parts' || empty($this->condition)) {
            return;
        }

        if (in_array(1, $this->condition) && empty($this->original)) {
            $this->addError('original', 'Необходимо заполнить «Оригинальность».');
        }
    }
}