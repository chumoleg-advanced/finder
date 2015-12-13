<?php

namespace common\components;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

class ActiveField extends \kartik\form\ActiveField
{
    /**
     * @param string     $type
     * @param array      $items
     * @param array      $options
     * @param bool|false $asButtonGroup
     *
     * @return ActiveField
     */
    protected function getToggleFieldList($type, $items, $options = [], $asButtonGroup = false)
    {
        $disabled = ArrayHelper::remove($options, 'disabledItems', []);
        $readonly = ArrayHelper::remove($options, 'readonlyItems', []);
        if ($asButtonGroup) {
            Html::addCssClass($options, 'btn-group');
            $options['data-toggle'] = 'buttons';
            $options['inline'] = true;
            if (!isset($options['itemOptions']['labelOptions']['class'])) {
                $options['itemOptions']['labelOptions']['class'] = 'btn btn-default';
            }
        }
        $inline = ArrayHelper::remove($options, 'inline', false);
        $inputType = "{$type}List";
        $this->initDisability($options['itemOptions']);
        $css = $this->form->disabled ? ' disabled' : '';
        $css = $this->form->readonly ? $css . ' readonly' : $css;
        if ($inline && !isset($options['itemOptions']['labelOptions']['class'])) {
            $options['itemOptions']['labelOptions']['class'] = "{$type}-inline{$css}";
        } elseif (!isset($options['item'])) {
            $labelOptions = ArrayHelper::getValue($options, 'itemOptions.labelOptions');
            $options['item'] = function (
                $index,
                $label,
                $name,
                $checked,
                $value
            ) use (
                $type,
                $css,
                $disabled,
                $readonly,
                $asButtonGroup,
                $labelOptions
            ) {
                $opts = [
                    'label'      => $label,
                    'value'      => $value,
                    'data-value' => $value,
                    'disabled'   => $this->form->disabled,
                    'readonly'   => $this->form->readonly,
                ];
                if ($asButtonGroup && $checked) {
                    Html::addCssClass($labelOptions, 'active');
                }
                if (!empty($disabled) && in_array($value, $disabled) || $this->form->disabled) {
                    Html::addCssClass($labelOptions, 'disabled');
                    $opts['disabled'] = true;
                }
                if (!empty($readonly) && in_array($value, $readonly) || $this->form->readonly) {
                    Html::addCssClass($labelOptions, 'disabled');
                    $opts['readonly'] = true;
                }
                if ($checked && $asButtonGroup) {
                    Html::addCssClass($labelOptions, 'active');
                }
                $opts['labelOptions'] = $labelOptions;
                $out = Html::$type($name, $checked, $opts);
                return $asButtonGroup ? $out : "<div class='{$type}{$css}'>{$out}</div>";
            };
        }

        return \yii\widgets\ActiveField::$inputType($items, $options);
    }
}