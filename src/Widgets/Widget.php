<?php declare(strict_types=1);

namespace Tkui\Widgets;

use Tkui\Options;

/**
 * Basic widget.
 */
interface Widget
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
     * Gets the widget options.
     */
    public function options(): Options;

    /**
     * Parent widget.
     *
     * The last widget in the chain must be Window.
     */
    public function parent(): Container;
}