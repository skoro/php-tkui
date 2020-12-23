<?php declare(strict_types=1);

namespace TclTk\Widgets;

use TclTk\App;
use TclTk\Options;
use TclTk\Interp;

/**
 * Application window.
 *
 * @property string $title
 * @property string $state
 */
class Window implements TkWidget
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

    private App $app;
    private Interp $interp;
    private Options $options;

    /**
     * Child widgets callbacks.
     *
     * Index is the widget path and value - the callback function.
     *
     * @todo must be WeakMap (php8) or polyfill ?
     */
    private array $callbacks;

    /**
     * @todo Create a namespace for window callbacks handler.
     */
    private const CALLBACK_HANDLER = 'PHP_tk_ui_Handler';

    public function __construct(App $app, string $title)
    {
        $this->app = $app;
        $this->interp = $app->tk()->interp();
        $this->callbacks = [];
        $this->options = $this->initOptions();
        $this->title = $title;
        $this->createCallbackHandler();
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
    }

    protected function createCallbackHandler()
    {
        $this->interp->createCommand(self::CALLBACK_HANDLER, function ($path) {
            $this->callbacks[$path]();
        });
    }

    /**
     * @inheritdoc
     */
    public function path(): string
    {
        return '.';
    }

    /**
     * @inheritdoc
     */
    public function id(): string
    {
        return '.';
    }

    public function registerCallback(TkWidget $widget, callable $callback): string
    {
        $this->callbacks[$widget->path()] = $callback;
        return self::CALLBACK_HANDLER . ' ' . $widget->path();
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
    public function parent(): TkWidget
    {
        return $this;
    }

    /**
     * Application instance.
     */
    public function app(): App
    {
        return $this->app;
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
                    $this->app->tclEval('wm', 'title', $this->path(), $value);
                    break;
                case 'state':
                    $this->app->tclEval('wm', 'state', $this->path(), $value);
            }
        }
    }
}