<?php declare(strict_types=1);

namespace TclTk\Widgets;

use InvalidArgumentException;
use TclTk\Options;

/**
 * Implementation of Tk button widget.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/button.htm
 *
 * @property string $text
 * @property string $default
 * @property string $state
 * @property string $overRelief
 * @property callable $command
 * @property int $height
 * @property int $width
 */
class Button extends Widget
{
    /**
     * Button states for 'state' option.
     */
    const STATE_NORMAL = 'normal';
    const STATE_ACTIVE = 'active';
    const STATE_DISABLED = 'disabled';

    public function __construct(TkWidget $parent, string $title, array $options = [])
    {
        $options['text'] = $title;
        parent::__construct($parent, 'button', 'b', $options);
    }

    /**
     * @inheritdoc
     */
    protected function initWidgetOptions(): Options
    {
        return new Options([
            'command' => null,
            'default' => null,
            'height' => null,
            'overRelief' => null,
            'state' => null,
            'width' => null,
        ]);
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
     * @inheritdoc
     */
    public function __set(string $name, $value)
    {
        if ($name === 'command') {
            if (is_callable($value)) {
                $value = $this->window()->registerCallback($this, $value);
            } else {
                throw new InvalidArgumentException(sprintf('"%s" is not a valid button command.', $value));
            }
        }
        parent::__set($name, $value);
    }

    /**
     * Flash the button.
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