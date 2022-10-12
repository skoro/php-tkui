<?php declare(strict_types=1);

namespace Tkui\Widgets;

use Tkui\Widgets\Common\HasScrollBars;
use Tkui\Widgets\Common\Scrollable;

abstract class ScrollableWidget extends TkWidget implements Scrollable
{
    use HasScrollBars;
}
