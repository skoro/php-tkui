<?php declare(strict_types=1);

namespace PhpGui\Layouts;

use PhpGui\Evaluator;
use PhpGui\Options;
use PhpGui\Widgets\Widget;

/**
 * Base layout manager.
 */
abstract class Manager implements LayoutManager
{
    private Evaluator $eval;

    public function __construct(Evaluator $eval)
    {
        $this->eval = $eval;
    }

    /**
     * The options layout manager can handle.
     */
    protected function createLayoutOptions(): Options
    {
        return new Options();
    }

    /**
     * The layout manager implementation command.
     */
    abstract protected function command(): string;

    /**
     * Call the layout manager engine.
     */
    protected function call(string $method, ...$options)
    {
        $this->eval->tclEval($this->command(), $method, ...$options);
    }

    /**
     * @inheritdoc
     */
    public function add(Widget $widget, array $options = []): self
    {
        $this->call($widget->path(), ...$this->createLayoutOptions()->mergeAsArray($options)->asStringArray());
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function remove(Widget $widget): self
    {
        $this->call('forget', $widget->path());
        return $this;
    }
}