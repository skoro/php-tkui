<?php declare(strict_types=1);

namespace TclTk;

use FFI\CData;

/**
 * Tcl variable.
 */
class Variable
{
    private Interp $interp;
    private Tcl $tcl;
    private string $name;
    private string $index;

    public function __construct(Interp $interp, string $name, string $index = '', $value = NULL)
    {
        $this->interp = $interp;
        $this->tcl = $interp->tcl();
        $this->name = $name;
        $this->index = $index;
        $this->set($value);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function index(): string
    {
        return $this->index;
    }

    public function set($value)
    {
        $this->tcl->setVar($this->interp, $this->name, $this->index, $value);
    }

    public function asString(): string
    {
        return $this->tcl->getStringFromObj($this->getObj());
    }

    public function asBool(): bool
    {
        return $this->tcl->getBooleanFromObj($this->interp, $this->getObj());
    }

    public function asInt(): int
    {
        return $this->tcl->getIntFromObj($this->interp, $this->getObj());
    }

    public function asFloat(): float
    {
        return $this->tcl->getFloatFromObj($this->interp, $this->getObj());
    }

    protected function getObj(): CData
    {
        return $this->tcl->getVar($this->interp, $this->name, $this->index);
    }

    public function __toString(): string
    {
       return $this->asString();
    }
}
