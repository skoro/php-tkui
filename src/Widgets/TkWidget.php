<?php declare(strict_types=1);

namespace PhpGui\Widgets;

use PhpGui\Evaluator;
use PhpGui\Layouts\Grid;
use PhpGui\Layouts\Pack;
use PhpGui\Options;

/**
 * A basic Tk widget implementation.
 */
abstract class TkWidget implements Widget
{
    private Container $parent;
    private static array $idCounter = [];
    private Options $options;
    private int $id;
    private Evaluator $eval;

    /**
     * Tk widget command.
     */
    protected string $widget;

    /**
     * The widget short name.
     */
    protected string $name;

    /**
     * Creates a new widget.
     *
     * @param Container $parent The parent widget.
     * @param array $options Override widget options.
     */
    public function __construct(Container $parent, array $options = [])
    {
        $this->generateId();
        $this->parent = $parent;
        $this->eval = $parent->getEval();
        $this->options = $this->initOptions()
                              ->merge($this->initWidgetOptions())
                              ->mergeAsArray($options);
        $this->make();
    }

    public function __destruct()
    {
        // TODO: unregister var.
    }

    private function generateId(): void
    {
        if (!isset(static::$idCounter[static::class])) {
            static::$idCounter[static::class] = 0;
        }
        $this->id = ++static::$idCounter[static::class];
    }

    /**
     * Initialize the common widget options.
     */
    protected function initOptions(): Options
    {
        return new WidgetOptions();
    }

    /**
     * Initialize specific widget options.
     */
    protected function initWidgetOptions(): Options
    {
        return new Options();
    }

    /**
     * Create Tk widget.
     */
    protected function make()
    {
        $this->eval->tclEval($this->widget, $this->path(), ...$this->options->asStringArray());
    }

    /**
     * @inheritdoc
     */
    public function widget(): string
    {
        return $this->widget;
    }

    /**
     * @inheritdoc
     */
    public function path(): string
    {
        $pid = $this->parent->path();
        // Widget belongs to the root window.
        if ($pid === '.') {
            return '.' . $this->id();
        }

        return $pid . '.' . $this->id();
    }

    /**
     * @inheritdoc
     */
    public function id(): string
    {
        return $this->name . $this->id;
    }

    protected function getEval(): Evaluator
    {
        return $this->eval;
    }

    /**
     * Call the widget method.
     */
    protected function call(string $method, ...$args): string
    {
        return $this->eval->tclEval($this->path(), $method, ...$args);
    }

    public function pack(array $options = []): Pack
    {
        return new Pack($this, $options);
    }

    public function grid(array $options = []): Grid
    {
        return new Grid($this, $options);
    }

    /**
     * Get the widget option value.
     */
    public function __get(string $name)
    {
        $value = $this->options->$name;
        if ($value === null) {
            $value = $this->call('cget', Options::getTclOption($name));
            $this->options->$name = $value;
        }
        return $value;
    }

    /**
     * Set the widget option value.
     */
    public function __set(string $name, $value)
    {
        if ($this->options->$name !== $value) {
            $this->options->$name = $value;
            $this->call('configure', ...$this->options->only($name)->asStringArray());
        }
    }

    /**
     * @inheritdoc
     */
    public function options(): Options
    {
        return $this->options;
    }

    /**
     * @inheritdoc
     */
    public function parent(): Container
    {
        return $this->parent;
    }

    /**
     * Force to focus widget.
     */
    public function focus(): self
    {
        $this->eval->tclEval('focus', $this->path());
        return $this;
    }

    /**
     * Change a widget's position in the stacking order.
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/raise.htm
     */
    public function raise(): self
    {
        $this->eval->tclEval('raise', $this->path());
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function bind(string $event, ?callable $callback): self
    {
        $this->parent->bindWidget($this, $event, $callback);
        return $this;
    }
}