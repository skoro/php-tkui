<?php declare(strict_types=1);

namespace TclTk\Widgets\Buttons;

use InvalidArgumentException;
use TclTk\Options;
use TclTk\Widgets\TkWidget;
use TclTk\Widgets\Widget;

/**
 * Parent of button classes.
 *
 * @property string $state
 * @property string $overRelief
 * @property callable $command
 * @property int $height
 * @property int $width
 */
abstract class GenericButton extends Widget
{
    /**
     * States for the 'state' option.
     */
    const STATE_NORMAL = 'normal';
    const STATE_ACTIVE = 'active';
    const STATE_DISABLED = 'disabled';

    /** @var callable */
    private $commandValue;

    /**
     * @inheritdoc
     */
    public function __construct(TkWidget $parent, string $widget, string $name, array $options = [])
    {
        // When the command is passed as an option we must
        // use the button's property assigning to explicitly
        // register a callback otherwise the command won't be registered.
        $command = null;
        if (isset($options['command'])) {
            $command = $options['command'];
            unset($options['command']);
        }

        parent::__construct($parent, $widget, $name, $options);

        // Register the command from the options.
        if ($command !== null) {
            $this->command = $command;
        }
    }

    /**
     * @inheritdoc
     */
    protected function initOptions(): Options
    {
        return parent::initOptions()->mergeAsArray([
            'state' => null,
            'width' => null,
            'height' => null,
            'command' => null,
            'overRelief' => null,
        ]);
    }

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
                $value = $this->window()->registerCallback($this, $value);
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

    /**
     * Flashes the button.
     *
     * This operation is ignored if the button's state is disabled.
     *
     * @link http://www.tcl.tk/man/tcl8.6/TkCmd/button.htm#M16
     */
    public function flash(): void
    {
        $this->call('flash');
    }

    /**
     * Manually click the button.
     *
     * @link http://www.tcl.tk/man/tcl8.6/TkCmd/button.htm#M17
     */
    public function invoke(): void
    {
        $this->call('invoke');
    }

    public function isDisabled(): bool
    {
        return $this->state === self::STATE_DISABLED;
    }

    public function isActive(): bool
    {
        return $this->state === self::STATE_ACTIVE;
    }

    public function isNormal(): bool
    {
        return $this->state === self::STATE_NORMAL;
    }
}