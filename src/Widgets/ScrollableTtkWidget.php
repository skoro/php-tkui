<?php

declare(strict_types=1);

namespace Tkui\Widgets;

use Tkui\Widgets\Common\HasScrollBars;

abstract class ScrollableTtkWidget extends TtkWidget
{
    use HasScrollBars;
}
