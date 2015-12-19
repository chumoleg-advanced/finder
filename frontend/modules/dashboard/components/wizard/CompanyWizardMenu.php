<?php

namespace app\modules\dashboard\components\wizard;

/**
 * WizardMenu class.
 * Creates a menu from the wizard steps.
 */
class CompanyWizardMenu extends \beastbytes\wizard\WizardMenu
{
    /**
     * Initialise the widget
     */
    public function init()
    {
//        $route = ['/' . $this->wizard->owner->route];
//        $params = $this->wizard->owner->actionParams;
        $steps = $this->wizard->steps;
        $index = array_search($this->step, $steps);

        foreach ($steps as $step) {
            $stepIndex = array_search($step, $steps);
//            $params[$this->wizard->queryParam] = $step;

            if ($stepIndex == $index) {
                $active = true;
                $class = $this->currentStepCssClass;
//                $url = array_merge($route, $params);

            } elseif ($stepIndex < $index) {
                $active = false;
                $class = $this->pastStepCssClass;
//                $url = ($this->wizard->forwardOnly ? null : array_merge($route, $params));

            } else {
                $active = false;
                $class = $this->futureStepCssClass;
//                $url = null;
            }

            // Дописал это
            if (!empty($class) && !empty($this->itemOptions['class'])) {
                $class .= ' ' . $this->itemOptions['class'];
            }

            $this->items[] = [
                'label'   => $this->wizard->stepLabel($step),
//                'url'     => $url,
                'active'  => $active,
                'options' => compact('class'),
            ];

            if (!empty($this->finalItem)) {
                $this->items[] = $this->finalItem;
            }
        }
    }
}