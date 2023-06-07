<?php declare(strict_types=1);

namespace Tkui\TclTk;

use FFI\CData;
use ReflectionMethod;
use LogicException;
use Tkui\Support\WithLogger;
use Tkui\TclTk\Exceptions\TclException;
use Tkui\TclTk\Exceptions\TclInterpException;

/**
 * Tcl interpreter implementation.
 */
class Interp
{
    use WithLogger;
    
    private ?ListVariable $argv = null;

    public function __construct(
        private readonly Tcl $tcl,
        private readonly CData $interp,
    ) {
    }

    /**
     * Initializes Tcl interpreter.
     */
    public function init(): void
    {
        $this->debug('interp init');
        $this->tcl->init($this);
        $this->argv = $this->createListVariable('argv');
        $this->debug('end interp init');
    }

    public function cdata(): CData
    {
        return $this->interp;
    }

    /**
     * Calls underlying Tcl api with replaced interp parameter.
     *
     * @throws TclException The method not exist in Tcl Api.
     */
    public function callTcl(string $method, mixed ...$arguments)
    {
        if (method_exists($this->tcl, $method)) {
            // TODO: cache reflection results to improve performance.
            $ref = new ReflectionMethod($this->tcl, $method);
            $params = $ref->getParameters();
            if ($params) {
                /** @phpstan-ignore-next-line */
                if ($params[0]->getType()->getName() === Interp::class) {
                    array_unshift($arguments, $this);
                }
            }
            $this->debug($method, array_map(
                // CData arguments cannot be serialized to strings.
                fn ($argument) => $argument instanceof CData ? 'FFI\CData' : $argument,
                $arguments
            ));
            return $this->tcl->$method(...$arguments);
        }

        throw new TclException("Method \"$method\" not found in tcl api.");
    }

    /**
     * @throws LogicException When interp is not initialized.
     */
    public function argv(): ListVariable
    {
        if ($this->argv === null) {
            throw new LogicException('Interp not initialized.');
        }
        return $this->argv;
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
     *
     * An evaluation result can be found via getStringResult().
     * @see Interp::getStringResult
     */
    public function eval(string $script)
    {
        $this->debug('eval', ['script' => $script]);
        $this->tcl->eval($this, $script);
    }

    /**
     * Creates a Tcl command.
     *
     * @param string   $command  The command name.
     * @param callable $callback The command callback. The callback accepts arguments as strings.
     */
    public function createCommand(string $command, callable $callback)
    {
        $this->debug('createCommand', ['command' => $command]);
        $this->tcl->createCommand($this, $command, function ($data, $interp, $objc, $objv) use ($callback) {
            $params = [];
            for ($i = 1; $i < $objc; $i ++) {
                $params[] = $this->tcl->getString($objv[$i]);
            }
            $result = $callback(...$params);
            if ($result !== null) {
                $this->tcl->setResult($this, $result);
            }
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
     * @throws TclException
     * @throws TclInterpException
     */
    public function createVariable(string $varName, ?string $arrIndex = NULL, mixed $value = NULL): Variable
    {
        $this->debug('createVariable', [
            'varName' => $varName,
            'arrIndex' => $arrIndex,
            'value' => $value,
        ]);

        return new Variable($this, $varName, $arrIndex, $value);
    }

    /**
     * Creates a Tcl list variable.
     */
    public function createListVariable(string $varName): ListVariable
    {
        $this->debug('createListVariable', [
            'varName' => $varName,
        ]);

        return new ListVariable($this, $varName);
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
            throw $this->throwInterpException('Cannot convert the Tcl result to a dictionary');
        }

        foreach (array_chunk($tclList, 2) as $chunk) {
            [$option, $value] = $chunk;
            $dict[$option] = $value;
        }

        return $dict;
    }

    /**
     * A helper for throwing interp exception.
     *
     * @throws TclInterpException
     */
    public function throwInterpException(string $message): TclInterpException
    {
        throw new TclInterpException($this, $message);
    }
}
