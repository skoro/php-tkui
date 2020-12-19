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
     * @param string          $command
     * @param string|string[] $args
     * @param Options         $options
     */
    public function exec(string $command, $args, ?Options $options = null): string;

    /**
     * Gets the parent window to which the widget belongs.
     */
    public function getWindow(): Window;

    /**
     * Gets the widget options.
     */
    public function getOptions(): Options;
}