<?php declare(strict_types=1);

namespace TclTk\Widgets;

use TclTk\Exceptions\TkException;
use TclTk\Options;

/**
 * A basic Ttk widget implementation.
 *
 * @property string $class
 * @property string $cursor
 * @property bool $takeFocus
 * @property string $style
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
     * @throws TkException When ttk package is not loaded.
     */
    protected function make()
    {
        if (! $this->window()->app()->hasTtk()) {
            throw new TkException('ttk support is not available.');
        }
        parent::make();        
    }

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

    public function state(string $state): self
    {
        $this->call('state', $state);
        return $this;
    }

    public function inState(string $state): bool
    {
        return (bool) $this->call('instate', $state);
    }
}