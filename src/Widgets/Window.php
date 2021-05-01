<?php declare(strict_types=1);

namespace TclTk\Widgets;

use TclTk\Application;
use TclTk\Evaluator;
use TclTk\Options;
use TclTk\Layouts\Grid;
use TclTk\Layouts\Pack;
use TclTk\Tcl;

/**
 * Application window.
 *
 * @property string $title
 * @property string $state
 */
class Window implements Container
{
    /**
     * The window states.
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/wm.htm#M62
     */
    const STATE_NORMAL = 'normal';
    const STATE_ICONIC = 'iconic';
    const STATE_WITHDRAWN = 'withdrawn';
    const STATE_ICON = 'icon';
    const STATE_ZOOMED = 'zoomed';

    private Application $app;
    private Options $options;

    /**
     * Window instance id.
     */
    private int $id;

    private static int $idCounter = 0;

    public function __construct(Application $app, string $title)
    {
        $this->generateId();
        $this->app = $app;
        $this->options = $this->initOptions();
        $this->createWindow();
        $this->title = $title;
    }

    protected function initOptions(): Options
    {
        return new Options([
            'title' => '',
            'state' => '',
        ]);
    }

    public function __destruct()
    {
        // TODO: unregister callback handler.
        // TODO: destroy all variables.
    }

    private function generateId(): void
    {
        $this->id = static::$idCounter++;
    }

    protected function createWindow(): void
    {
        if ($this->id != 0) {
            $this->app->tclEval('toplevel', $this->path());
        }
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
    public function id(): string
    {
        return ($this->id === 0) ? '' : 'w' . $this->id;
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
    public function widget(): string
    {
        return 'toplevel';
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
        return $this;
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
                    $this->app->tclEval('wm', 'title', $this->path(), Tcl::quoteString($value));
                    break;
                case 'state':
                    $this->app->tclEval('wm', 'state', $this->path(), $value);
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
    public function getEval(): Evaluator
    {
        return $this->app;
    }

    public function bindWidget(Widget $widget, string $event, ?callable $callback): self
    {
        if ($callback === null) {
            $this->app->unbindWidget($widget, $event);
        } else {
            $this->app->bindWidget($widget, $event, $callback);
        }
        return $this;
    }
}