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
    private string $name;
    private Options $options;

    private Pack $pack;

    /**
     * Creates a new widget.
     *
     * @param Widget $parent  The parent widget.
     * @param string $name    The widget name.
     * @param array  $options The widget options.
     */
    public function __construct(TkWidget $parent, string $name, array $options = [])
    {
        $this->parent = $parent;
        $this->name = $name;
        $this->options = new Options($options);
        $this->pack = new Pack($this);
        $this->updateCounters();
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

    protected function make(string $cmd)
    {
        $this->exec($cmd, $this->path(), $this->options);
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
     * @inheritdoc
     */
    public function exec(string $command, $args, ?Options $options = null): string
    {
        return $this->parent->exec($command, $args, $options);
    }

    public function pack(array $options = [])
    {
        $this->pack->pack($options);
    }

    /**
     * @inheritdoc
     */
    public function getWindow(): Window
    {
        return $this->parent->getWindow();
    }

    public function __get(string $name)
    {
        return $this->options->$name;
    }

    public function __set(string $name, $value)
    {
        if ($this->options->$name != $value) {
            $this->options->$name = $value;
            $this->exec($this->path(), 'configure', $this->options->only($name));
        }
    }

    /**
     * @inheritdoc
     */
    public function getOptions(): Options
    {
        return $this->options;
    }
}