<?php declare(strict_types=1);

namespace PhpGui\TclTk;

use PhpGui\Application;
use PhpGui\Bindings;
use PhpGui\FontManager;
use PhpGui\HasLogger;
use PhpGui\TclTk\Exceptions\TclException;
use PhpGui\TclTk\Exceptions\TclInterpException;
use PhpGui\Widgets\Widget;

/**
 * Main application.
 */
class TkApplication implements Application
{
    use HasLogger;

    private Tk $tk;
    private Interp $interp;
    private Bindings $bindings;
    private ?TkThemeManager $themeManager;
    private TkFontManager $fontManager;

    /**
     * @var Variable[]
     * @todo WeakMap ?
     */
    private array $vars;

    /**
     * Widgets callbacks.
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

    public function __construct(Tk $tk)
    {
        $this->tk = $tk;
        $this->ttkEnabled = false;
        $this->interp = $tk->interp();
        $this->bindings = $this->createBindings();
        $this->themeManager = null;
        $this->fontManager = $this->createFontManager();
        $this->vars = [];
        $this->callbacks = [];
        $this->createCallbackHandler();
    }

    protected function createBindings(): Bindings
    {
        return new TkBindings($this->interp);
    }

    protected function createFontManager(): FontManager
    {
        return new TkFontManager($this->interp);
    }

    /**
     * @inheritdoc
     */
    public function tclEval(...$args): string
    {
        // TODO: to improve performance not all the arguments should be quoted
        // but only those which are parameters. But this requires a new method
        // like this: tclCall($command, $method, ...$args)
        // and only $args must be quoted.
        $script = implode(' ', array_map(fn ($arg) => $this->encloseArg($arg), $args));
        $this->interp->eval($script);

        return $this->interp->getStringResult();
    }

    /**
     * Initialization of ttk package.
     */
    protected function initTtk(): void
    {
        try {
            $this->interp->eval('package require Ttk');
            $this->themeManager = $this->createThemeManager();
        } catch (TclInterpException $e) {
            // TODO: ttk must be required ?
            $this->themeManager = null;
            $this->info('package ttk is not found');
        }
    }

    // TODO: should it be ThemeManager or TkThemeManager ?
    protected function createThemeManager(): TkThemeManager
    {
        return new TkThemeManager($this->interp);
    }

    /**
     * The application has ttk support.
     */
    public function hasTtk(): bool
    {
        return $this->themeManager !== null;
    }

    /**
     * Encloses the argument in the curly brackets.
     *
     * This function automatically detects when the argument
     * should be enclosed in curly brackets.
     *
     * @see App::tclEval()
     *
     * @param mixed $arg
     */
    protected function encloseArg($arg): string
    {
        if (is_string($arg)) {
            $chr = $arg[0];
            if ($chr === '"' || $chr === "'" || $chr === '{' || $chr === '[') {
                return $arg;
            }
            return (strpos($arg, ' ') === FALSE && strpos($arg, "\n") === FALSE)  ? $arg : Tcl::quoteString($arg);
        }
        elseif (is_array($arg)) {
            // TODO: deep into $arg to check nested array.
            $arg = '{' . implode(' ', $arg) . '}';
        }
        return (string) $arg;
    }

    /**
     * Initializes Tcl and Tk libraries.
     */
    public function init(): void
    {
        $this->debug('init');
        $this->interp->init();
        $this->tk->init();
        $this->initTtk();
    }

    /**
     * Application's the main loop.
     *
     * Will process all the app events.
     */
    public function run(): void
    {
        $this->debug('run');
        $this->tk->mainLoop();
    }

    public function tk(): Tk
    {
        return $this->tk;
    }

    /**
     * Quits the application and deletes all the widgets.
     */
    public function quit(): void
    {
        $this->debug('destroy');
        $this->tclEval('destroy', '.');
    }

    /**
     * Sets the widget binding.
     */
    public function bindWidget(Widget $widget, $event, $callback): void
    {
        $this->bindings->bindWidget($widget, $event, $callback);
    }

    /**
     * Unbinds the event from the widget.
     */
    public function unbindWidget(Widget $widget, $event): void
    {
        $this->bindings->unbindWidget($widget, $event);
    }

    public function bindings(): Bindings
    {
        return $this->bindings;
    }

    /**
     * @throws TclException When ttk is not supported.
     */
    public function getThemeManager(): TkThemeManager
    {
        if ($this->hasTtk()) {
            return $this->themeManager;
        }
        throw new TclException('ttk is not supported.');
    }

    protected function createCallbackHandler()
    {
        $this->interp->createCommand(self::CALLBACK_HANDLER, function (...$args) {
            $path = array_shift($args);
            // TODO: check if arguments are empty ?
            [$widget, $callback] = $this->callbacks[$path];
            $callback($widget, ...$args);
        });
    }

    public function registerVar($varName): Variable
    {
        if ($varName instanceof Widget) {
            $varName = $varName->path();
        }
        if (! isset($this->vars[$varName])) {
            // TODO: variable in namespace ?
            // TODO: generate an array index for access performance.
            $this->vars[$varName] = $this->interp->createVariable($varName);
        }
        return $this->vars[$varName];
    }

    public function unregisterVar($varName): void
    {
        if ($varName instanceof Widget) {
            $varName = $varName->path();
        }
        if (! isset($this->vars[$varName])) {
            throw new TclException(sprintf('Variable "%s" is not registered.', $varName));
        }
        // Implicitly call of Variable's __destruct().
        unset($this->vars[$varName]);
    }

    /**
     * @inheritdoc
     */
    public function registerCallback(Widget $widget, callable $callback, array $args = []): string
    {
        // TODO: it would be better to use WeakMap.
        //       in that case it will be like this:
        //       $this->callbacks[$widget] = $callback;
        $this->callbacks[$widget->path()] = [$widget, $callback];
        return trim(self::CALLBACK_HANDLER . ' ' . $widget->path() . ' ' . implode(' ', $args));
    }

    /**
     * @inheritdoc
     */
    public function getFontManager(): FontManager
    {
        return $this->fontManager;
    }
}