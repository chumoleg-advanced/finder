<?php

namespace frontend\modules\dashboard\components;

use beastbytes\wizard\WizardMenu;

/**
 * WizardMenu class.
 * Creates a menu from the wizard steps.
 */
class CompanyWizardMenu extends WizardMenu
{
    /**
     * Initialise the widget
     */
    public function init()
    {
        $steps = $this->wizard->steps;
        $index = array_search($this->step, $steps);

        foreach ($steps as $step) {
            $stepIndex = array_search($step, $steps);
            if ($stepIndex == $index) {
                $active = true;
                $class = $this->currentStepCssClass;

            } elseif ($stepIndex < $index) {
                $active = false;
                $class = $this->pastStepCssClass;

            } else {
                $active = false;
                $class = $this->futureStepCssClass;
            }

            if (!empty($class) && !empty($this->itemOptions['class'])) {
                $class .= ' ' . $this->itemOptions['class'];
            }

            $this->items[] = [
                'label'   => $this->wizard->stepLabel($step),
                'active'  => $active,
                'options' => compact('class'),
            ];

            if (!empty($this->finalItem)) {
                $this->items[] = $this->finalItem;
            }
        }
    }
}