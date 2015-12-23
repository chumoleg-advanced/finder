<?php

namespace app\searchForms;

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
            [['condition'], 'required', 'on' => ['parts']],
            [['image'], 'safe'],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, gif, png', 'maxFiles' => 5],
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
}