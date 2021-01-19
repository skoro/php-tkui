<?php declare(strict_types=1);

namespace TclTk\Widgets;

use TclTk\Options;

/**
 * Basic Tk widget.
 */
interface TkWidget
{
    /**
     * Widget's path hierarchy including its id.
     */
    public function path(): string;

    /**
     * Unique widget id (without hierarchy and leading dot).
     */
    public function id(): string;

    /**
     * A Tk command used for constructing the widget.
     */
    public function widget(): string;

    /**
     * Gets the parent window to which the widget belongs.
     */
    public function window(): Window;

    /**
     * Gets the widget options.
     */
    public function options(): Options;

    /**
     * Parent widget.
     *
     * The last widget in the chain must be Window.
     */
    public function parent(): TkWidget;

    /**
     * Sets the event binding to the widget.
     *
     * @param string       $event    The event name.
     * @param callable|NULL $callback The event callback or in case of NULL
     *                               removes the callback from the widget.
     */
    public function bind(string $event, ?callable $callback): self;
}