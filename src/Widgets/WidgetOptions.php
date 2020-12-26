<?php declare(strict_types=1);

namespace TclTk\Widgets;

use TclTk\Options;

/**
 * Common Tk widget options.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/options.htm
 */
class WidgetOptions extends Options
{
    const JUSTIFY_LEFT = 'left';
    const JUSTIFY_CENTER = 'center';
    const JUSTIFY_RIGHT = 'right';

    const ORIENT_HORIZONTAL = 'horizontal';
    const ORIENT_VERTICAL = 'vertical';

    const RELIEF_RAISED = 'raised';
    const RELIEF_SUNKEN = 'sunken';
    const RELIEF_FLAT = 'flat';
    const RELIEF_RIDGE = 'ridge';
    const RELIEF_SOLID = 'solid';
    const RELIEF_GROOVE = 'groove';

    public function __construct(array $options = [])
    {
        parent::__construct($this->defaults());
        $this->mergeAsArray($options);
    }

    protected function defaults(): array
    {
        return [
            'activeBackground' => null,
            'activeBorderWidth' => null,
            'activeForeground' => null,
            'anchor' => null,
            'background' => null,
            'bitmap' => null,
            'borderWidth' => null,
            'cursor' => null,
            'compound' => null,
            'disabledForeground' => null,
            'exportSelection' => null,
            'font' => null,
            'foreground' => null,
            'highlightBackground' => null,
            'highlightColor' => null,
            'highlightThickness' => null,
            'image' => null,
            'insertBackground' => null,
            'insertBorderWidth' => null,
            'insertOffTime' => null,
            'insertOnTime' => null,
            'insertWidth' => null,
            'jump' => null,
            'justify' => null,
            'orient' => null,
            'padX' => null,
            'padY' => null,
            'relief' => null,
            'repeatDelay' => null,
            'repeatInterval' => null,
            'selectBackground' => null,
            'selectBorderWidth' => null,
            'selectForeground' => null,
            'setGrid' => null,
            'takeFocus' => null,
            'text' => null,
            'textVariable' => null,
            'troughColor' => null,
            'underline' => null,
            'wrapLength' => null,
            'xScrollCommand' => null,
            'yScrollCommand' => null,
        ];
    }
}