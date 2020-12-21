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
        return $this->options[$name] ?? null;
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
        $map = array_map(
            fn ($name, $value) => $value === null ? '' : "-$name {$this->quoteValue((string) $value)}",
            array_keys($this->options), $this->options);
        return implode(' ', array_filter($map));
    }

    /**
     * Returns options as an array.
     */
    public function asArray(): array
    {
        return $this->options;
    }

    /**
     * Returns options as Tcl string.
     */
    public function __toString()
    {
        return $this->asTcl();
    }

    public function has(string $name): bool
    {
        return array_key_exists($name, $this->options);
    }

    /**
     * Quote the option's value.
     */
    protected function quoteValue(string $value): string
    {
        return strpos($value, ' ') !== false ? '{' . $value . '}' : $value;
    }

    /**
     * Merges another options.
     */
    public function merge(Options $options): self
    {
        return $this->mergeAsArray($options->asArray());
    }

    public function mergeAsArray(array $options): self
    {
        $this->options = array_merge($this->options, $options);
        return $this;
    }

    /**
     * Constructs new options with specified names.
     */
    public function only(string ...$names): Options
    {
        return new static(
            array_map(fn ($name) => $this->$name, array_combine($names, $names))
        );
    }

    /**
     * @return string[]
     */
    public function names(): array
    {
        return array_keys($this->options);
    }
}