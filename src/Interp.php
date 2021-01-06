<?php declare(strict_types=1);

namespace TclTk;

use FFI\CData;

/**
 * Tcl interpreter implementation.
 */
class Interp
{
    private Tcl $tcl;
    private CData $interp;

    public function __construct(Tcl $tcl, CData $interp)
    {
        $this->tcl = $tcl;
        $this->interp = $interp;
    }

    /**
     * Initializes Tcl interpreter.
     */
    public function init(): void
    {
        $this->tcl->init($this);
    }

    public function cdata(): CData
    {
        return $this->interp;
    }

    /**
     * Gets the string result of the last executed command.
     */
    public function getStringResult(): string
    {
        return $this->tcl->getStringResult($this);
    }

    /**
     * Evaluates a Tcl script.
     */
    public function eval(string $script)
    {
        echo "[DEBUG] $script\n";
        $this->tcl->eval($this, $script);
    }

    public function tcl(): Tcl
    {
        return $this->tcl;
    }

    /**
     * Creates a Tcl command.
     */
    public function createCommand(string $command, callable $callback)
    {
        $this->tcl->createCommand($this, $command, function ($data, $interp, $objc, $objv) use ($callback) {
            $params = [];
            // TODO: the condition is already checked by for() loop and can be removed.
            if ($objc > 1) {
                for ($i = 1; $i < $objc; $i ++) {
                    $params[] = $this->tcl->getString($objv[$i]);
                }
            }
            $callback(...$params);
        });
    }

    public function createVariable(string $name, string $index = '', $value = NULL): Variable
    {
        return new Variable($this, $name, $index, $value);
    }
}
