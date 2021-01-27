<?php declare(strict_types=1);

namespace TclTk\Widgets\Ttk;

use TclTk\Exceptions\TkException;
use TclTk\Options;
use TclTk\Widgets\TkWidget;

/**
 * A basic Ttk widget implementation.
 */
abstract class TtkWidget extends TkWidget
{
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
}