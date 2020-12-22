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
        $script = implode(' ', $args);
        $this->interp->eval($script);

        return $this->interp->getStringResult();
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