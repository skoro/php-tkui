<?php declare(strict_types=1);

namespace Tkui\Widgets\Exceptions;

use Tkui\Widgets\Widget;

/**
 * The widget cannot set or update a font.
 */
class FontNotSupportedException extends WidgetException
{
    public function __construct(Widget $widget)
    {
        parent::__construct($widget, 'Font is not supported by widget.');
    }
}