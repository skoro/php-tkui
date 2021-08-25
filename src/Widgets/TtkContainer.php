<?php declare(strict_types=1);

namespace PhpGui\Widgets;

use RuntimeException;
use PhpGui\Evaluator;
use PhpGui\Layouts\Grid;
use PhpGui\Layouts\Pack;
use PhpGui\Layouts\Place;
use PhpGui\Windows\Window;

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

    /**
     * @inheritdoc
     */
    public function pack($widget, array $options = []): Pack
    {
        return $this->parent()->pack($widget, $options);
    }

    /**
     * @inheritdoc
     */
    public function grid($widget, array $options = []): Grid
    {
        return $this->parent()->grid($widget, $options);
    }

    /**
     * @inheritdoc
     */
    public function place($widget, array $options = []): Place
    {
        return $this->parent()->place($widget, $options);
    }
}