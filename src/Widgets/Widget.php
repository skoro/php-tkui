<?php declare(strict_types=1);

namespace TclTk\Widgets;

use TclTk\Layouts\Pack;
use TclTk\Options;

/**
 * A basic Tk widget implementation.
 */
abstract class Widget implements TkWidget
{
    private TkWidget $parent;
    private static array $counters = [];
    private string $widget;
    private string $name;
    private WidgetOptions $options;

    private Pack $pack;

    /**
     * Creates a new widget.
     *
     * @param Widget $parent  The parent widget.
     * @param string $widget  Tk widget command.
     * @param string $name    The widget name.
     * @param array  $options Override widget options.
     */
    public function __construct(TkWidget $parent, string $widget, string $name, array $options = [])
    {
        $this->parent = $parent;
        $this->widget = $widget;
        $this->name = $name;
        $this->pack = new Pack($this);
        $this->options = $this->initOptions()
                              ->merge($this->initWidgetOptions())
                              ->mergeAsArray($options);
        $this->updateCounters();
        $this->make();
    }

    public function __destruct()
    {
        // TODO: destroy widget.
    }

    private function updateCounters()
    {
        if (!isset(static::$counters[static::class])) {
            static::$counters[static::class] = 0;
        }
        static::$counters[static::class]++;
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
        $this->window()->exec($this->widget, $this->path(), $this->options);
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
        return $this->name . static::$counters[static::class];
    }

    /**
     * Executes the widget command.
     */
    protected function exec($args, ?Options $options = null): string
    {
        return $this->window()->exec($this->path(), $args, $options);
    }

    public function pack(array $options = [])
    {
        $this->pack->pack($options);
    }

    /**
     * @inheritdoc
     */
    public function window(): Window
    {
        return $this->parent->window();
    }

    public function __get(string $name)
    {
        $value = $this->options->$name;
        if ($value === null) {
            $value = $this->exec(['cget', '-' . $name]);
            $this->options->$name = $value;
        }
        return $value;
    }

    public function __set(string $name, $value)
    {
        if ($this->options->$name != $value) {
            $this->options->$name = $value;
            $this->exec('configure', $this->options->only($name));
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
    public function parent(): TkWidget
    {
        return $this->parent;
    }
}