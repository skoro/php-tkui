<?php

declare(strict_types=1);

namespace Tkui\Widgets;

use Tkui\Exceptions\InvalidValueTypeException;
use Tkui\Font;
use Tkui\Image;
use Tkui\Options;
use Tkui\Widgets\Consts\Compound;
use Tkui\Widgets\Exceptions\FontNotSupportedException;
use SplSubject;
use Tkui\TclTk\TclOptions;
use Tkui\Widgets\Consts\State;

/**
 * A basic Ttk widget implementation.
 *
 * @property string $class
 * @property string $cursor
 * @property bool $takeFocus
 * @property string $style
 * @property Image $image
 * @property Compound $compound
 * @property Font $font
 * @property State $state
 */
abstract class TtkWidget extends TkWidget
{
    /**
     * @inheritdoc
     */
    protected function initOptions(): Options
    {
        return new TclOptions([
            'class' => null,
            'cursor' => null,
            'takeFocus' => null,
            'style' => null,
            'image' => null,
            'compound' => null,
        ]);
    }

    public function __get($name)
    {
        /**
         * 'state' property has not a real option in ttk widget.
         */
        if ($name === 'state') {
            return $this->getState();
        }
        return parent::__get($name);
    }

    /**
     * @throws FontNotSupportedException
     * @throws InvalidValueTypeException When the value is not a Font or State instance.
     */
    public function __set(string $name, $value)
    {
        switch ($name) {
            case 'font':
                // TODO: font also can be a string like TkFixedFont.
                if ($value instanceof Font) {
                    $this->setInternalFont($value);
                } else {
                    throw new InvalidValueTypeException(Font::class, $value);
                }
                break;

            case 'state':
                if ($value instanceof State) {
                    $this->setInternalState($value);
                } else {
                    throw new InvalidValueTypeException(State::class, $value);
                }
                break;
        }

        parent::__set($name, $value);
    }

    protected function setInternalState(State $state): void
    {
        $this->call('state', $state->value);
    }

    protected function getState(): State
    {
        return State::from($this->call('state'));
    }

    public function inState(State $state): bool
    {
        return (bool) $this->call('instate', $state->value);
    }

    /**
     * @throws FontNotSupportedException When the widget doesn't have "-font" option.
     */
    protected function setInternalFont(Font $font): void
    {
        if ($this->hasFont()) {
            // Previous font is not observable anymore.
            // Checking the font value via "font" property of the instance
            // will emit "cget" command, to avoid it use options directly.
            /** @phpstan-ignore-next-line */
            if ($this->options()->font !== null) {
                $this->font->detach($this);
            }
            $font->attach($this);
        } else {
            throw new FontNotSupportedException($this);
        }
    }

    /**
     * @throws FontNotSupportedException When the widget doesn't have "-font" option.
     */
    protected function updateFont(Font $font): void
    {
        if ($this->hasFont() && $this->font === $font) {
            $this->configure('-font', $font);
        } else {
            throw new FontNotSupportedException($this);
        }
    }

    /**
     * Whether the widget has "-font" option.
     */
    protected function hasFont(): bool
    {
        return $this->options()->has('font');
    }

    /**
     * @inheritdoc
     * @throws FontNotSupportedException
     */
    public function update(SplSubject|Font $subject): void
    {
        parent::update($subject);

        if ($subject instanceof Font) {
            $this->updateFont($subject);
        }
    }
}
