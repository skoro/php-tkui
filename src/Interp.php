<?php declare(strict_types=1);

namespace TclTk;

use FFI\CData;

class Interp
{
    private Tcl $tcl;
    private CData $interp;

    public function __construct(Tcl $tcl, CData $interp)
    {
        $this->tcl = $tcl;
        $this->interp = $interp;
    }

    public function init(): void
    {
        $this->tcl->init($this);
    }

    public function cdata(): CData
    {
        return $this->interp;
    }

    public function getStringResult(): string
    {
        return $this->tcl->getStringResult($this);
    }

    public function eval(string $script)
    {
        $this->tcl->eval($this, $script);
    }

    public function tcl(): Tcl
    {
        return $this->tcl;
    }
}