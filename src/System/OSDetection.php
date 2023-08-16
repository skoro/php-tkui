<?php declare(strict_types=1);

namespace Tkui\System;

use Tkui\Exceptions\UnsupportedOSException;

class OSDetection
{
    /**
     * @throws UnsupportedOSException When the OperationSystem is not supported.
     */
    public static function detect(): OS
    {
        return match (strtolower(PHP_OS_FAMILY)) {
            'windows'   => new Windows(),
            'linux'     => new Linux(),
            'darwin'    => new Darwin(),
            default     => throw new UnsupportedOSException(),
        };
    }
}
