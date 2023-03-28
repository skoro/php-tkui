<?php

declare(strict_types=1);

namespace Tkui\Widgets\Consts;

/**
 * Selection modes for 'selectMode' option.
 */
enum SelectMode: string
{
    case SINGLE     = 'single';
    case BROWSE     = 'browse';
    case MULTIPLE   = 'multiple';
    case EXTENDED   = 'extended';
}
