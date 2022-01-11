<?php declare(strict_types=1);

namespace Tkui\TclTk;

use FFI\CData;

/**
 * Tcl variable.
 */
class Variable
{
    private Interp $interp;
    private Tcl $tcl;
    private string $varName;
    private ?string $arrIndex;

    /**
     * @param Interp $interp   The Tcl interp.
     * @param string $varName  The variable name.
     * @param string $arrIndex When the variable is an array this is the index.
     * @param int|string|float|bool $value The variable value.
     */
    public function __construct(Interp $interp, string $varName, ?string $arrIndex = NULL, $value = NULL)
    {
        $this->interp = $interp;
        $this->tcl = $interp->tcl();
        $this->varName = $varName;
        $this->arrIndex = $arrIndex;
        $this->set($value);
    }

    public function __destruct()
    {
        $this->tcl->unsetVar($this->interp, $this->varName, $this->arrIndex);
    }

    public function varName(): string
    {
        return $this->varName;
    }

    public function arrIndex(): string
    {
        return $this->arrIndex;
    }

    /**
     * Returns the variable name with array index for using in Tcl scripts.
     */
    public function varNameWithIndex(): string
    {
        return empty($this->arrIndex) ? $this->varName : sprintf('%s(%s)', $this->varName, $this->arrIndex);
    }

    public function set($value)
    {
        $this->tcl->setVar($this->interp, $this->varName, $this->arrIndex, $value);
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
        return $this->tcl->getVar($this->interp, $this->varName, $this->arrIndex);
    }

    public function __toString(): string
    {
       return $this->varNameWithIndex();
    }
}
