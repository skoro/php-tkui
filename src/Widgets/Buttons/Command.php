<?php declare(strict_types=1);

namespace Tkui\Widgets\Buttons;

use InvalidArgumentException;

/**
 * Implements widget's '-command' option and onClick method.
 */
trait Command
{
    /** @var callable */
    private $commandValue;

    /**
     * @inheritdoc
     */
    public function __set(string $name, $value)
    {
        // A special case for 'command' option.
        // Register a valid callback (Tcl proc) to handle
        // a button click from php.
        // Keep in mind that 'command' getter will return
        // a Tcl script instead of the callback.
        if ($name === 'command') {
            if (is_callable($value)) {
                $this->commandValue = $value;
                $value = $this->parent()->getEval()->registerCallback($this, $value);
            } else {
                throw new InvalidArgumentException(sprintf('"%s" is not a valid button command.', $value));
            }
        }
        parent::__set($name, $value);
    }

    /**
     * @inheritdoc
     */
    public function __get($name)
    {
        if ($name === 'command') {
            return $this->commandValue;
        }
        return parent::__get($name);
    }

    /**
     * Wrapper for 'command' property.
     */
    public function onClick(callable $callback): self
    {
        $this->command = $callback;
        return $this;
    }
}