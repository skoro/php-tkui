<?php declare(strict_types=1);

namespace TclTk;

class App
{
    private Tk $tk;
    private Interp $interp;

    public function __construct(Tk $tk)
    {
        $this->tk = $tk;
        $this->interp = $tk->interp();
    }

    public static function create(): self
    {
        $loader = new FFILoader();
        $tcl = new Tcl($loader->loadTcl());
        $interp = $tcl->createInterp();
        $app = new static(new Tk($loader->loadTk(), $interp));
        $app->init();
        return $app;
    }

    public function tclEval(string $script)
    {
        $this->interp->eval($script);
    }

    public function init(): void
    {
        $this->interp->init();
        $this->tk->init();
    }

    public function mainLoop(): void
    {
        $this->tk->mainLoop();
    }

    public function tk(): Tk
    {
        return $this->tk;
    }
}