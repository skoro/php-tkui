<?php declare(strict_types=1);

namespace Tkui;

interface Environment
{
    /**
     * Reads the environment value.
     * 
     * @param mixed $default
     *
     * @return mixed
     */
    public function getValue(string $param, $default = null);
}
