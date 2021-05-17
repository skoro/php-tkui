<?php declare(strict_types=1);

namespace TclTk;

use TclTk\Windows\Window;

/**
 * Tk implementation of Window Manager.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/wm.htm
 */
class TkWindowManager implements WindowManager
{
    private Evaluator $eval;

    public function __construct(Evaluator $eval)
    {
        $this->eval = $eval;
    }

    /**
     * @inheritdoc
     */
    public function setTitle(Window $window, string $title): void
    {
        $this->setWm($window, 'title', Tcl::quoteString($title));
    }

    /**
     * @inheritdoc
     */
    public function setState(Window $window, string $state): void
    {
        $this->setWm($window, 'state', $state);
    }

    /**
     * @inheritdoc
     */
    public function getState(Window $window): string
    {
        return (string) $this->getWm($window, 'state');
    }

    /**
     * @inheritdoc
     */
    public function iconify(Window $window): void
    {
        $this->setWm($window, 'iconify');
    }

    /**
     * @inheritdoc
     */
    public function deiconify(Window $window): void
    {
        $this->setWm($window, 'deiconify');
    }

    /**
     * Proxy the window command to Tk wm command.
     */
    protected function setWm(Window $w, string $command, string ...$value): void
    {
        $this->eval->tclEval('wm', $command, $w->path(), ...$value);
    }

    /**
     * Get the Tk wm command result.
     *
     * @return mixed
     */
    protected function getWm(Window $w, string $command)
    {
        return $this->eval->tclEval('wm', $command);
    }
}