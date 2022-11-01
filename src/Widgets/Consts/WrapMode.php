<?php declare(strict_types=1);

namespace Tkui\Widgets\Consts;

/**
 * Values for "wrap" property.
 */
enum WrapMode: string
{
    case WRAP_NONE = 'none';
    case WRAP_CHAR = 'char';
    case WRAP_WORD = 'word';
}