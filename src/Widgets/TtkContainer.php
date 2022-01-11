<?php declare(strict_types=1);

namespace Tkui\Widgets;

use Tkui\Evaluator;
use Tkui\Layouts\Grid;
use Tkui\Layouts\Pack;
use Tkui\Layouts\Place;
use Tkui\Windows\Window;

abstract class TtkContainer extends TtkWidget implements Container
{
    public function window(): Window
    {
        $p = $this->parent();
        while (! ($p instanceof Window)) {
            // FIXME: can be infinite loop ?
            $p = $p->parent();
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