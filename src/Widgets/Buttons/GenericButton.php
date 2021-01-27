<?php declare(strict_types=1);

namespace TclTk\Widgets\Buttons;

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
abstract class GenericButton extends TkWidget
{
    use Command;

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
    public function __construct(Widget $parent, string $widget, string $name, array $options = [])
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