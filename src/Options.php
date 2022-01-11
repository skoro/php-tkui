<?php declare(strict_types=1);

namespace Tkui;

use InvalidArgumentException;
use Tkui\Widgets\Widget;
use Tkui\TclTk\Tcl;

/**
 * Tcl command options.
 */
class Options
{
    private array $options = [];

    final public function __construct(array $options = [])
    {
        $this->mergeAsArray($this->defaults(), $options);
    }

    protected function defaults(): array
    {
        return [];
    }

    /**
     * @throws InvalidArgumentException When option name is not widget option.
     */
    public function __get($name)
    {
        if ($this->has($name)) {
            return $this->options[$name];
        }
        throw new InvalidArgumentException("'$name' is not widget option.");
    }

    /**
     * @throws InvalidArgumentException When option name is not widget option.
     */
    public function __set($name, $value)
    {
        if ($this->has($name)) {
            $this->options[$name] = $value;
        } else {
            throw new InvalidArgumentException("'$name' is not widget option.");
        }
    }

    /**
     * Converts options to a string suitable for Tcl command.
     *
     * @return string A string like "-option value -another {foo foo}"
     */
    public function asTcl(): string
    {
        return implode(' ', $this->asStringArray());
    }

    /**
     * Returns options as an array.
     */
    public function asArray(): array
    {
        return $this->options;
    }

    /**
     * Formats options as a string array suitable for tcl eval() command.
     *
     * @return string[]
     */
    public function asStringArray(): array
    {
        $str = [];
        foreach ($this->options as $option => $value) {
            if ($value !== null) {
                $str[] = static::getTclOption($option);
                if (is_bool($value)) {
                    $str[] = $value ? '1' : '0';
                } elseif (is_string($value)) {
                    if ($option === 'text') {
                        $value = Tcl::quoteString($value);
                    }
                    $str[] = $value === '' ? '{}' : $value;
                } elseif ($value instanceof Widget) {
                    $str[] = $value->path();
                } elseif (is_array($value)) {
                    $str[] = Tcl::arrayToList($value);
                } else {
                    $str[] = (string) $value;
                }
            }
        }
        return $str;
    }

    /**
     * Format the option as a Tcl string.
     */
    public static function getTclOption(string $option): string
    {
        return Tcl::strToOption($option);
    }

    /**
     * Returns options as Tcl string.
     */
    public function __toString()
    {
        return $this->asTcl();
    }

    /**
     * Check whether the option exist.
     */
    public function has(string $name): bool
    {
        return array_key_exists($name, $this->options);
    }

    /**
     * Merge options from another option instance.
     */
    public function merge(Options $options): self
    {
        return $this->mergeAsArray($options->asArray());
    }

    /**
     * Merge options from an array.
     */
    public function mergeAsArray(array ...$options): self
    {
        $this->options = array_merge($this->options, ...$options);
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
     * Returns a list of option names.
     *
     * @return string[]
     */
    public function names(): array
    {
        return array_keys($this->options);
    }

    /**
     * Array options to Tcl string converter.
     */
    public static function tclString(array $options): string
    {
        return (new static($options))->asTcl();
    }

    /**
     * Creates a new options instance from the plain list.
     *
     * Example:
     * <code>
     * $options = Options::createFromList(['size', 10, 'color', 'red']);
     * $options->size; // 10
     * $options->color; // red
     *
     * // The same:
     * $options = Options::createFromList(['-size', 10, '-color', 'red'], true);
     * </code>
     *
     * @param bool $asOptions When enabled odd list items must be options.
     */
    public static function createFromList(array $list, bool $asOptions = true): self
    {
        if (count($list) % 2 !== 0) {
            throw new InvalidArgumentException('The list must have even number of elements.');
        }

        $options = [];

        foreach (array_chunk($list, 2) as [$key, $value]) {
            if ($asOptions) {
                if ($key[0] === '-') {
                    $key = substr($key, 1);
                } else {
                    throw new InvalidArgumentException("Item '$key' must be an option.");
                }
            }
            $options[$key] = $value;
        }

        return new static($options);
    }
}