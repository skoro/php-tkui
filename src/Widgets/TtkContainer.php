<?php declare(strict_types=1);

namespace Tkui\Widgets;

use Tkui\Evaluator;
use Tkui\Layouts\Grid;
use Tkui\Layouts\LayoutManager;
use Tkui\Layouts\Pack;
use Tkui\Layouts\Place;
use Tkui\Options;
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

    public function bindWidget(Widget $widget, string $event, ?callable $callback): static
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
    public function pack(Widget|array $widget, array|Options $options = []): LayoutManager|Pack
    {
        return $this->parent()->pack($widget, $options);
    }

    /**
     * @inheritdoc
     */
    public function grid(Widget|array $widget, array|Options $options = []): LayoutManager|Grid
    {
        return $this->parent()->grid($widget, $options);
    }

    /**
     * @inheritdoc
     */
    public function place(Widget|array $widget, array|Options $options = []): LayoutManager|Place
    {
        return $this->parent()->place($widget, $options);
    }
}