<?php declare(strict_types=1);

namespace TclTk\Layouts;

use TclTk\Widgets\TkWidget;

interface LayoutManager
{
    /**
     * The widget where layout manager can operate.
     */
    public function widget(): TkWidget;
}