<?php declare(strict_types=1);

namespace Tkui\Widgets;

use Tkui\Evaluator;
use Tkui\Layouts\Grid;
use Tkui\Layouts\Pack;
use Tkui\Layouts\Place;
use Tkui\Windows\Window;

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

    /**
     * Do the widget layout using pack manager.
     *
     * @param Widget|Widget[] $widget  The widget or widgets to be packed.
     * @param array           $options The packing options applied to widget(s).
     */
    public function pack($widget, array $options = []): Pack;

    /**
     * Do the widget layout using grid manager.
     *
     * @param Widget|Widget[] $widget  The widget or widgets to be packed.
     * @param array           $options The grid manager options.
     */
    public function grid($widget, array $options = []): Grid;

    /**
     * Do the widget layout using place manager.
     *
     * @param Widget|Widget[] $widget  The widget or widgets to be placed.
     * @param array           $options The place manager options.
     */
    public function place($widget, array $options = []): Place;
}