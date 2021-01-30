<?php declare(strict_types=1);

namespace TclTk\Widgets;

use LogicException;
use TclTk\Options;

/**
 * Implementation of Tk scrollbar widget.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/scrollbar.htm
 *
 * @property string $orient
 */
class Scrollbar extends TkWidget
{
    protected string $widget = 'scrollbar';
    protected string $name = 'scr';

    /**
     * @param bool $vert Vertical scrollbar otherwise horizontal. Same as setting 'orient' option.
     */
    public function __construct(Widget $parent, bool $vert = TRUE, array $options = [])
    {
        $options['orient'] = $vert ? WidgetOptions::ORIENT_VERTICAL : WidgetOptions::ORIENT_HORIZONTAL;
        parent::__construct($parent, $options);
    }

    /**
     * @inheritdoc
     */
    public function initWidgetOptions(): Options
    {
        return new Options([
            'activeRelief' => null,
            'command' => null,
            'elementBorderWidth' => null,
            'width' => null,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function __set(string $name, $value)
    {
        if ($name === 'command' && $value instanceof ScrollableWidget) {
            $value = $value->path() . ' ' . $this->getOrientToView();
        }
        parent::__set($name, $value);
    }

    /**
     * Converts the scrollbar orient option to a view name.
     */
    public function getOrientToView(): string
    {
        switch ($this->orient) {
            case WidgetOptions::ORIENT_HORIZONTAL:
                return 'xview';

            case WidgetOptions::ORIENT_VERTICAL:
                return 'yview';
        }

        throw new LogicException('Invalid orient: ' . $this->orient);
    }
}