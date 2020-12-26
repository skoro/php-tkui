<?php declare(strict_types=1);

namespace TclTk\Widgets;

use TclTk\Options;

/**
 * Implementation of Tk scrollbar widget.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/scrollbar.htm
 */
class Scrollbar extends Widget
{
    /**
     * @param bool $vert Vertical scrollbar otherwise horizontal. Same as setting 'orient' option.
     */
    public function __construct(TkWidget $parent, bool $vert = TRUE, array $options = [])
    {
        $options['orient'] = $vert ? WidgetOptions::ORIENT_VERTICAL : WidgetOptions::ORIENT_HORIZONTAL;
        parent::__construct($parent, 'scrollbar', 'sb', $options);
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
}