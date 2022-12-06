<?php declare(strict_types=1);

namespace Tkui\Widgets;

use Tkui\Widgets\Common\Scrollable;
use Tkui\Widgets\Common\WithScrollBars;

abstract class ScrollableWidget extends TkWidget implements Scrollable
{
    use WithScrollBars;
}
