<?php declare(strict_types=1);

namespace TclTk\Widgets;

use TclTk\Evaluator;
use TclTk\Windows\Window;

/**
 * Container widget.
 */
interface Container extends Widget
{
    /**
     * The window container belongs to.
     */
    public function window(): Window;

    public function bindWidget(Widget $widget, string $event, ?callable $callback): self;

    public function getEval(): Evaluator;
}