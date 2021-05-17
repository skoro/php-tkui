<?php declare(strict_types=1);

namespace TclTk\Windows;

use TclTk\Layouts\Grid;
use TclTk\Layouts\Pack;
use TclTk\Options;
use TclTk\Tcl;
use TclTk\Widgets\Widget;

/**
 * Shares the features for window implementations.
 */
abstract class BaseWindow implements Window
{
    private Options $options;

    /**
     * Window instance id.
     */
    private int $id;

    private static int $idCounter = 0;

    /**
     * @param string $title The window title.
     */
    public function __construct(string $title)
    {
        $this->generateId();
        $this->options = $this->initOptions();
        $this->createWindow();
        $this->title = $title;
    }

    public function __destruct()
    {
        // TODO: unregister callback handler.
        // TODO: destroy all variables.
    }

    protected function initOptions(): Options
    {
        return new Options([
            'title' => '',
            'state' => '',
        ]);
    }

    /**
     * Actual window creation.
     */
    abstract protected function createWindow(): void;

    private function generateId(): void
    {
        $this->id = static::$idCounter++;
    }

    /**
     * @inheritdoc
     */
    public function widget(): string
    {
        return 'toplevel';
    }

    /**
     * @inheritdoc
     */
    public function window(): Window
    {
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function id(): string
    {
        return 'w' . $this->id;
    }

    /**
     * @inheritdoc
     */
    public function path(): string
    {
        return '.' . $this->id();
    }

    /**
     * @inheritdoc
     */
    public function options(): Options
    {
        return $this->options;
    }

    public function __get($name)
    {
        return $this->options->$name;
    }

    public function __set($name, $value)
    {
        if ($this->options->has($name) && $this->options->$name !== $value) {
            $this->options->$name = $value;
            // TODO: must be a proxy to "wm" command.
            switch ($name) {
                case 'title':
                    $this->getEval()->tclEval('wm', 'title', $this->path(), Tcl::quoteString($value));
                    break;
                case 'state':
                    $this->getEval()->tclEval('wm', 'state', $this->path(), $value);
                    break;
            }
        }
    }

    // @todo consider to accept an array of widgets then we can pack
    //       several widgets at once.
    public function pack(Widget $widget, array $options = []): Pack
    {
        return new Pack($widget, $options);
    }

    public function grid(Widget $widget, array $options = []): Grid
    {
        return new Grid($widget, $options);
    }

    /**
     * @inheritdoc
     */
    public function bind(string $event, ?callable $callback): self
    {
        return $this->bindWidget($this, $event, $callback);
    }
}