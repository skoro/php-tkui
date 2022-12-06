<?php

declare(strict_types=1);

namespace Tkui\Widgets;

use Tkui\Widgets\Common\Scrollable;
use Tkui\Widgets\Common\WithScrollBars;

abstract class ScrollableTtkWidget extends TtkWidget implements Scrollable
{
    use WithScrollBars;
}
