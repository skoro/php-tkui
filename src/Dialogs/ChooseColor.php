<?php declare(strict_types=1);

namespace TclTk\Dialogs;

use TclTk\Options;

/**
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/chooseColor.htm
 *
 * @property string $initialColor
 * @property string $title
 */
class ChooseColor extends Dialog
{
    /**
     * @inheritdoc
     */
    protected function createOptions(): Options
    {
        return parent::createOptions()->mergeAsArray([
            'initialColor' => null,
            'title' => null,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function command(): string
    {
        return 'tk_chooseColor';
    }

    protected function doSuccess($value)
    {
        $this->initialColor = $value;
        parent::doSuccess($value);
    }
}