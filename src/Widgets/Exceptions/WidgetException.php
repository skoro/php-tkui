<?php declare(strict_types=1);

namespace Tkui\Widgets\Exceptions;

use Tkui\Exceptions\Exception;
use Tkui\Widgets\Widget;

/**
 * Generic widget exception.
 */
class WidgetException extends Exception
{
    private Widget $widget;

    public function __construct(Widget $widget, string $message)
    {
        parent::__construct($message);
        $this->widget = $widget;
    }

    public function getWidget(): Widget
    {
        return $this->widget;
    }
}