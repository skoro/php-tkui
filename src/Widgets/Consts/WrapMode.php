<?php declare(strict_types=1);

namespace Tkui\Widgets\Consts;

/**
 * Values for "wrap" property.
 */
enum WrapMode: string
{
    case NONE = 'none';
    case CHAR = 'char';
    case WORD = 'word';
}
