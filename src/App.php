<?php declare(strict_types=1);

namespace TclTk;

use TclTk\Exceptions\TclInterpException;
use TclTk\Widgets\TkWidget;

/**
 * Main application.
 */
class App
{
    private Tk $tk;
    private Interp $interp;
    private Bindings $bindings;
    private bool $ttkEnabled;

    public function __construct(Tk $tk)
    {
        $this->tk = $tk;
        $this->ttkEnabled = false;
        $this->interp = $tk->interp();
        $this->bindings = $this->initBindings();
    }

    protected function initBindings(): Bindings
    {
        return new Bindings($this->interp);
    }

    /**
     * Application builder.
     *
     * Loads and initializes Tcl and Tk libraries.
     */
    public static function create(): self
    {
        $loader = new FFILoader();
        $tcl = new Tcl($loader->loadTcl());
        $interp = $tcl->createInterp();
        $app = new static(new Tk($loader->loadTk(), $interp));
        $app->init();
        return $app;
    }

    /**
     * Evaluates a Tcl command.
     *
     * All the arguments will be concatenated as a script.
     */
    public function tclEval(...$args): string
    {
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
            foreach ($this->ttkWidgets() as $widget) {
                $this->interp->eval("interp alias {} $widget {} ttk::$widget");
            }
            $this->ttkEnabled = true;
        } catch (TclInterpException $e) {
            $this->ttkEnabled = false;
        }
    }

    /**
     * The application has ttk support.
     */
    public function hasTtk(): bool
    {
        return $this->ttkEnabled;
    }

    /**
     * Returns a list of Tk widgets that can be aliased to Ttk.
     *
     * @return string[]
     */
    public function ttkWidgets(): array
    {
        return [
            'button', 'label', 'entry', 'scrollbar',
        ];
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
            return strpos($arg, ' ') === FALSE ? $arg : Tcl::quoteString($arg);
        }
        return (string) $arg;
    }

    /**
     * Initializes Tcl and Tk libraries.
     */
    public function init(): void
    {
        $this->interp->init();
        $this->tk->init();
        $this->initTtk();
    }

    /**
     * Application's the main loop.
     *
     * Will process all the app events.
     */
    public function mainLoop(): void
    {
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
        $this->tclEval('destroy', '.');
    }

    /**
     * Sets the widget binding.
     */
    public function bind(TkWidget $widget, $event, $callback): void
    {
        $this->bindings->bindWidget($widget, $event, $callback);
    }

    /**
     * Unbinds the event from the widget.
     */
    public function unbind(TkWidget $widget, $event): void
    {
        $this->bindings->unbindWidget($widget, $event);
    }

    public function bindings(): Bindings
    {
        return $this->bindings;
    }
}
