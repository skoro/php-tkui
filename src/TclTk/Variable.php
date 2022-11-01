<?php declare(strict_types=1);

namespace Tkui\TclTk;

use FFI\CData;

/**
 * Tcl variable.
 */
class Variable
{
    /**
     * @param Interp $interp   The Tcl interp.
     * @param string $varName  The variable name.
     * @param string $arrIndex When the variable is an array this is the index.
     * @param int|string|float|bool $value The variable value.
     */
    public function __construct(
        private readonly Interp $interp,
        private readonly string $varName,
        private readonly ?string $arrIndex = NULL,
        $value = NULL
    ) {
        $this->set($value);
    }

    public function __destruct()
    {
        $this->interp->callTcl('unsetVar', $this->varName, $this->arrIndex);
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
        $this->interp->callTcl('setVar', $this->varName, $this->arrIndex, $value);
    }

    public function asString(): string
    {
        return $this->convertToType('getStringFromObj');
    }

    public function asBool(): bool
    {
        return $this->convertToType('getBooleanFromObj');
    }

    public function asInt(): int
    {
        return $this->convertToType('getIntFromObj');
    }

    public function asFloat(): float
    {
        return $this->convertToType('getFloatFromObj');
    }

    private function convertToType(string $method): mixed
    {
        return $this->interp->callTcl($method, $this->getObj());
    }

    protected function getObj(): CData
    {
        return $this->interp->callTcl('getVar', $this->varName, $this->arrIndex);
    }

    public function __toString(): string
    {
       return $this->varNameWithIndex();
    }
}
