<?php declare(strict_types=1);

namespace PhpGui;

use PhpGui\Widgets\Widget;

/**
 * Let you attach/detach widget bindings.
 */
interface Bindings
{
    /**
     * Attach the binding to the widget.
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/bind.htm
     */
    public function bindWidget(Widget $widget, string $event, callable $callback): void;

    /**
     * Detach the widget binding.
     */
    public function unbindWidget(Widget $widget, string $event): void;
}