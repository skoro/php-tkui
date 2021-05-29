<?php declare(strict_types=1);

namespace TclTk\Windows;

use TclTk\Layouts\Grid;
use TclTk\Layouts\Pack;
use TclTk\Options;
use TclTk\TkWindowManager;
use TclTk\Widgets\Widget;
use TclTk\WindowManager;

/**
 * Shares the features for window implementations.
 */
abstract class BaseWindow implements Window
{
    private Options $options;
    private WindowManager $wm;

    /**
     * Window instance id.
     */
    private int $id;

    private static int $idCounter = 0;

    public function __construct(string $title)
    {
        $this->generateId();
        $this->options = $this->initOptions();
        $this->wm = $this->createWindowManager();
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
     * @inheritdoc
     */
    public function close(): void
    {
        $this->getEval()->tclEval('destroy', $this->path());
    }

    /**
     * Create the window manager for the window.
     */
    protected function createWindowManager(): WindowManager
    {
        return new TkWindowManager($this->getEval(), $this);
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
            switch ($name) {
                case 'title':
                    $this->wm->setTitle($value);
                    break;
                case 'state':
                    $this->wm->setState($value);
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

    /**
     * @inheritdoc
     */
    public function getWindowManager(): WindowManager
    {
        return $this->wm;
    }
}