<?php declare(strict_types=1);

namespace PhpGui\Widgets\Exceptions;

use PhpGui\Widgets\Widget;

class TextStyleNotRegisteredException extends WidgetException
{
    private string $styleName;

    public function __construct(Widget $widget, string $styleName)
    {
        parent::__construct($widget, sprintf('Text style "%s" is not registered.', $styleName));
        $this->styleName = $styleName;
    }

    public function getStyleName(): string
    {
        return $this->styleName;
    }
}