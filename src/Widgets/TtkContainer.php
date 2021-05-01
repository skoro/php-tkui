<?php declare(strict_types=1);

namespace TclTk\Widgets;

use RuntimeException;
use TclTk\Evaluator;

abstract class TtkContainer extends TtkWidget implements Container
{
    public function window(): Window
    {
        $p = $this->parent();
        while ($p && (! $p instanceof Window)) {
            $p = $p->parent();
        }
        if (! $p) {
            throw new RuntimeException('Cannot get window.');
        }
        return $p;
    }

    public function bindWidget(Widget $widget, string $event, ?callable $callback): self
    {
        $this->parent()->bindWidget($widget, $event, $callback);
        return $this;
    }

    public function getEval(): Evaluator
    {
        return $this->parent()->getEval();
    }
}