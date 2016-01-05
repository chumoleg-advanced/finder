<?php

namespace common\components;

use Yii;
use yii\helpers\Html;

class ManageButton
{
    private static $cssClass = 'btn btn-default btn-sm';

    public static function view($url)
    {
        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
            'title'     => 'Просмотреть',
            'data-pjax' => '0',
            'class'     => self::$cssClass
        ]);
    }

    public static function offer($url)
    {
        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
            'title'     => 'Просмотреть и оставить предложение',
            'data-pjax' => '0',
            'class'     => self::$cssClass
        ]);
    }

    public static function update($url)
    {
        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
            'title'     => 'Редактировать',
            'data-pjax' => '0',
            'class'     => self::$cssClass
        ]);
    }

    public static function delete($url)
    {
        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
            'title'        => 'Удалить',
            'data-confirm' => 'Вы уверены, что хотите удалить эту запись',
            'data-method'  => 'post',
            'data-pjax'    => '0',
            'class'        => self::$cssClass
        ]);
    }

    public static function reset($url)
    {
        return Html::a('<span class="glyphicon glyphicon-repeat"></span>', $url, [
            'title'        => 'Сбросить',
            'data-confirm' => 'Вы уверены, что хотите сбросить статус этой записи',
            'data-method'  => 'post',
            'data-pjax'    => '0',
            'class'        => self::$cssClass
        ]);
    }

    public static function reject($url)
    {
        return Html::a('<span class="glyphicon glyphicon-remove"></span>', $url, [
            'title'        => 'Отклонить',
            'data-confirm' => 'Вы уверены, что хотите отклонить эту запись',
            'data-method'  => 'post',
            'data-pjax'    => '0',
            'class'        => self::$cssClass
        ]);
    }

    public static function accept($url)
    {
        return Html::a('<span class="glyphicon glyphicon-ok"></span>', $url, [
            'title'        => 'Одобрить',
            'data-confirm' => 'Вы уверены, что хотите одобрить эту запись',
            'data-method'  => 'post',
            'data-pjax'    => '0',
            'class'        => self::$cssClass
        ]);
    }
}