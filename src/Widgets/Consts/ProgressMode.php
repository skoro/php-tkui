<?php

declare(strict_types=1);

namespace Tkui\Widgets\Consts;

/**
 * Values for 'mode' property of progressbar widget.
 */
enum ProgressMode: string
{
    case DETERMINATE    = 'determinate';
    case INDETERMINATE  = 'indeterminate';
}
