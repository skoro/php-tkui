<?php

declare(strict_types=1);

namespace Tkui\Widgets\Consts;

/**
 * Active element draw styles for 'activeStyle' option.
 */
enum ActiveStyle: string
{
    case DOTBOX     = 'dotbox';
    case NONE       = 'none';
    case UNDERLINE  = 'underline';
}
