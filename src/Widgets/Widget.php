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
    private Options $options;

    private Pack $pack;

    /**
     * Creates a new widget.
     *
     * @param Widget $parent  The parent widget.
     * @param string $widget  Tk widget command.
     * @param string $name    The widget name.
     * @param array  $options The widget options.
     */
    public function __construct(TkWidget $parent, string $widget, string $name, array $options = [])
    {
        $this->parent = $parent;
        $this->widget = $widget;
        $this->name = $name;
        $this->options = new Options($options);
        $this->pack = new Pack($this);
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
        $pid = $this->parent ? $this->parent->id() : '';
        return $pid . $this->id();
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
        return $this->options->$name;
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