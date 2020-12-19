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
     * Widget command name.
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
}