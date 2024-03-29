<?php declare(strict_types=1);

namespace Tkui\Widgets;

use Tkui\Evaluator;
use Tkui\Layouts\Grid;
use Tkui\Layouts\LayoutManager;
use Tkui\Layouts\Pack;
use Tkui\Layouts\Place;
use Tkui\Options;
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
     * @param array|Options   $options The packing options applied to widget(s).
     */
    public function pack(Widget|array $widget, array|Options $options = []): LayoutManager|Pack;

    /**
     * Do the widget layout using grid manager.
     *
     * @param Widget|Widget[] $widget  The widget or widgets to be packed.
     * @param array|Options   $options The grid manager options.
     */
    public function grid(Widget|array $widget, array|Options $options = []): LayoutManager|Grid;

    /**
     * Do the widget layout using place manager.
     *
     * @param Widget|Widget[] $widget  The widget or widgets to be placed.
     * @param array|Options   $options The place manager options.
     */
    public function place(Widget|array $widget, array|Options $options = []): LayoutManager|Place;
}
