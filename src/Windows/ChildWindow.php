<?php declare(strict_types=1);

namespace Tkui\Windows;

use Tkui\Evaluator;
use Tkui\Widgets\Container;
use Tkui\Widgets\Widget;

/**
 * Child window implementation.
 */
class ChildWindow extends BaseWindow
{
    private Window $parent;

    public function __construct(Window $parent, string $title)
    {
        // The parent property must be initialized before
        // because of setting title that depends on getEval().
        $this->parent = $parent;
        parent::__construct($title);
    }

    /**
     * @inheritdoc
     */
    protected function createWindow(): void
    {
        $this->getEval()->tclEval($this->widget(), $this->path());
    }

    /**
     * @inheritdoc
     */
    public function parent(): Container
    {
        return $this->parent;
    }

    /**
     * @inheritdoc
     */
    public function getEval(): Evaluator
    {
        return $this->parent->getEval();
    }

    /**
     * @inheritdoc
     */
    public function bindWidget(Widget $widget, string $event, ?callable $callback): Container
    {
        return $this->parent->bindWidget($widget, $event, $callback);
    }
}