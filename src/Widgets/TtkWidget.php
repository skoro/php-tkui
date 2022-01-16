<?php declare(strict_types=1);

namespace Tkui\Widgets;

use Tkui\Font;
use Tkui\Image;
use Tkui\Options;
use Tkui\Widgets\Exceptions\FontNotSupportedException;
use SplSubject;

/**
 * A basic Ttk widget implementation.
 *
 * @property string $class
 * @property string $cursor
 * @property bool $takeFocus
 * @property string $style
 * @property Image $image
 * @property string $compound
 * @property Font $font
 */
abstract class TtkWidget extends TkWidget
{
    /**
     * Widget states.
     *
     * Not all widgets support states.
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_widget.htm#M-state
     */
    const STATE_ACTIVE = 'active';
    const STATE_DISABLED = 'disabled';
    const STATE_FOCUS = 'focus';
    const STATE_PRESSED = 'pressed';
    const STATE_SELECTED = 'selected';
    const STATE_BACKGROUND = 'background';
    const STATE_READONLY = 'readonly';
    const STATE_ALTERNATE = 'alternate';
    const STATE_INVALID = 'invalid';
    const STATE_HOVER = 'hover';

    /**
     * Specifies how to display the image relative to the text.
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_widget.htm#M-compound
     */
    const COMPOUND_NONE = 'none';
    const COMPOUND_TEXT = 'text';
    const COMPOUND_IMAGE = 'image';
    const COMPOUND_CENTER = 'center';
    const COMPOUND_TOP = 'top';
    const COMPOUND_BOTTOM = 'bottom';
    const COMPOUND_LEFT = 'left';
    const COMPOUND_RIGHT = 'right';
 
    /**
     * @inheritdoc
     */
    protected function initOptions(): Options
    {
        return new Options([
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
         * 'state' property is write-only and for getting a real widget
         * state the 'state' command without parameters will be used.
         */
        if ($name === 'state') {
            return $this->call('state');
        }
        return parent::__get($name);
    }

    public function __set(string $name, $value)
    {
        parent::__set($name, $value);

        // TODO: font also can be a string like TkFixedFont.
        if ($name === 'font' && $value instanceof Font) {
            $this->setFont($value);
        }
    }

    public function state(string $state): self
    {
        $this->call('state', $state);
        return $this;
    }

    public function inState(string $state): bool
    {
        return (bool) $this->call('instate', $state);
    }

    /**
     * @throws FontNotSupportedException When the widget doesn't have "-font" option.
     */
    protected function setFont(Font $font): void
    {
        if ($this->hasFont()) {
            // TODO: PHP8 $this->font?->detach($this)
            if ($this->font !== null) {
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
     */
    public function update(SplSubject $subject): void
    {
        parent::update($subject);

        if ($subject instanceof Font) {
            $this->updateFont($subject);
        }
    }
}