<?php declare(strict_types=1);

namespace TclTk;

class Options
{
    private array $options = [];

    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    public function __get($name)
    {
        return $this->options[$name];
    }

    public function __set($name, $value)
    {
        $this->options[$name] = $value;
    }

    public function asTcl(): string
    {
        $map = array_map(function ($name, $value) {
            return $value === null ? '' : "-$name {$value}";
        }, array_keys($this->options), $this->options);
        return implode(' ', array_filter($map));
    }

    public function asArray(): array
    {
        return $this->options;
    }

    public function __toString()
    {
        return $this->asTcl();
    }
}
