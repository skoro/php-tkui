<?php

declare(strict_types=1);

namespace Tkui\TclTk;

use InvalidArgumentException;

enum GuiType
{
    case X11;
    case WIN32;
    case AQUA;

    public static function fromString(string $guiType): static
    {
        return match ($guiType) {
            'x11'   => self::X11,
            'win32' => self::WIN32,
            'aqua'  => self::AQUA,
            default => throw new InvalidArgumentException("Not supported gui type: '$guiType'"),
        };
    }
}
