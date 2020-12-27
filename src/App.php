<?php declare(strict_types=1);

namespace TclTk;

/**
 * Main application.
 */
class App
{
    private Tk $tk;
    private Interp $interp;

    public function __construct(Tk $tk)
    {
        $this->tk = $tk;
        $this->interp = $tk->interp();
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
            return strpos($arg, ' ') === FALSE ? $arg : '{' . $arg . '}';
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
}