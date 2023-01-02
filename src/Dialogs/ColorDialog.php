<?php declare(strict_types=1);

namespace Tkui\Dialogs;

use Tkui\Options;

/**
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/chooseColor.htm
 *
 * @property string $initialColor
 * @property string $title
 */
class ColorDialog extends Dialog
{
    /**
     * @inheritdoc
     */
    protected function createOptions(): Options
    {
        return parent::createOptions()->with([
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

    protected function doSuccess(mixed $value): void
    {
        $this->initialColor = $value;
        parent::doSuccess($value);
    }
}
