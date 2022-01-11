<?php declare(strict_types=1);

namespace Tkui\Widgets\Common;

/**
 * The widget that can handle 'click' event from the user.
 */
interface Clickable
{
    /**
     * Handle a click event from the widget.
     */
    public function onClick(callable $callback): self;

    /**
     * Emulate a click event.
     */
    public function invoke(): self;
}