<?php declare(strict_types=1);

namespace PhpGui\Widgets;

use PhpGui\Evaluator;
use PhpGui\Layouts\Grid;
use PhpGui\Windows\Window;

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
     * Does the widget layout using pack manager.
     *
     * @param Widget|Widget[] $widget The widget or widgets list to be packed.
     * @param array $options         The packing options applied to widget(s).
     */
    public function pack($widget, array $options = []): Widget;

    public function grid(): Grid;
}