<?php declare(strict_types=1);

namespace TclTk\Layouts;

use TclTk\Widgets\Widget;

interface LayoutManager
{
    /**
     * Do widget layout.
     */
    public function manage(): Widget;
}