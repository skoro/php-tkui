<?php declare(strict_types=1);

namespace TclTk;

interface Environment
{
    /**
     * Reads the environment value.
     * 
     * @param mixed $default
     *
     * @return mixed
     */
    public function getEnv(string $param, $default = null);
}
