<?php declare(strict_types=1);

namespace Tkui;

use Tkui\Widgets\Widget;

/**
 * Let you attach/detach widget bindings.
 */
interface Bindings
{
    /**
     * Attach the binding to the widget.
     */
    public function bindWidget(Widget $widget, string $event, callable $callback): void;

    /**
     * Detach the widget binding.
     */
    public function unbindWidget(Widget $widget, string $event): void;
}