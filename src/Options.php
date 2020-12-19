<?php declare(strict_types=1);

namespace TclTk;

/**
 * Tcl command options.
 */
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

    /**
     * Converts options to a string suitable for Tcl command.
     *
     * @return string A string like "-option value -another {foo foo}"
     */
    public function asTcl(): string
    {
        $map = array_map(function ($name, $value) {
            return $value === null ? '' : "-$name {$this->quoteValue($value)}";
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

    public function has(string $name): bool
    {
        return isset($this->options[$name]);
    }

    protected function quoteValue(string $value): string
    {
        return strpos($value, ' ') !== false ? '{' . $value . '}' : $value;
    }

    public function merge(Options $options): self
    {
        $this->options = array_merge($this->options, $options);
        return $this;
    }
}
