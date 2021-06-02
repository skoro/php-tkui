<?php declare(strict_types=1);

namespace PhpGui\Layouts;

use PhpGui\Widgets\Widget;

interface LayoutManager
{
    /**
     * Do widget layout.
     */
    public function manage(): Widget;
}