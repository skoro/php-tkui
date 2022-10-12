<?php

declare(strict_types=1);

namespace Tkui\Widgets;

use Tkui\Widgets\Common\HasScrollBars;
use Tkui\Widgets\Common\Scrollable;

abstract class ScrollableTtkWidget extends TtkWidget implements Scrollable
{
    use HasScrollBars;
}
