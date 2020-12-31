<?php declare(strict_types=1);

namespace TclTk\Widgets\Buttons;

use TclTk\Options;

/**
 * Parent for switch button classes.
 */
abstract class SwitchableButton extends GenericButton
{
    /**
     * @inheritdoc
     */
    protected function initOptions(): Options
    {
        return parent::initOptions()->mergeAsArray([
            'indicatorOn' => null,
            'offRelief' => null,
            'selectColor' => null,
            'selectImage' => null,
            'tristateImage' => null,
            'tristateValue' => null,
        ]);
    }

    /**
     * Selects the checkbutton.
     */
    public function select(): self
    {
        $this->call('select');
        return $this;
    }

    /**
     * Deselects the checkbutton.
     */
    public function deselect(): self
    {
        $this->call('deselect');
        return $this;
    }
}