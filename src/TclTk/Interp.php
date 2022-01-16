<?php declare(strict_types=1);

namespace Tkui\TclTk;

use FFI\CData;
use Tkui\HasLogger;
use Tkui\TclTk\Exceptions\TclException;
use Tkui\TclTk\Exceptions\TclInterpException;

/**
 * Tcl interpreter implementation.
 */
class Interp
{
    use HasLogger;

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
        $this->debug('init');
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
        $this->debug('eval', ['script' => $script]);
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
        $this->debug('createCommand', ['command' => $command]);
        $this->tcl->createCommand($this, $command, function ($data, $interp, $objc, $objv) use ($callback) {
            $params = [];
            for ($i = 1; $i < $objc; $i ++) {
                $params[] = $this->tcl->getString($objv[$i]);
            }
            $callback(...$params);
        });
    }

    /**
     * @throws TclInterpException When the command delete failed.
     */
    public function deleteCommand(string $command): void
    {
        $this->debug('deleteCommand', ['command' => $command]);
        $this->tcl->deleteCommand($this, $command);
    }

    /**
     * Creates a Tcl variable instance.
     *
     * @param mixed $value
     *
     * @throws TclException
     * @throws TclInterpException
     */
    public function createVariable(string $varName, ?string $arrIndex = NULL, $value = NULL): Variable
    {
        $this->debug('createVariable', [
            'varName' => $varName,
            'arrIndex' => $arrIndex,
            'value' => $value,
        ]);
        return new Variable($this, $varName, $arrIndex, $value);
    }

    /**
     * Gets the interp eval result as a list of strings.
     */
    public function getListResult(): array
    {
        return $this->tcl->getListResult($this);
    }

    /**
     * Returns the result as a key value array.
     *
     * Some Tcl commands returns a result that can be used
     * as a dictionary (key-value).
     *
     * @throws TclInterpException When the result is not even.
     */
    public function getDictResult(): array
    {
        $dict = [];
        $tclList = $this->getListResult();

        if (count($tclList) % 2 !== 0) {
            throw $this->createInterpException('Cannot convert the Tcl result to a dictionary');
        }

        foreach (array_chunk($tclList, 2) as $chunk) {
            [$option, $value] = $chunk;
            $dict[$option] = $value;
        }

        return $dict;
    }

    protected function createInterpException(string $message): TclInterpException
    {
        return new TclInterpException($this, $message);
    }
}
