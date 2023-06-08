<?php declare(strict_types=1);

namespace Tkui\TclTk;

use InvalidArgumentException;
use Tkui\Options;
use Tkui\Widgets\Widget;

/**
 * Tcl command options.
 */
class TclOptions extends Options
{
    /**
     * Converts options to a string suitable for Tcl command.
     *
     * @return string A string like "-option value -another {foo foo}"
     */
    public function toString(): string
    {
        return implode(' ', $this->toStringList());
    }

    /**
     * Formats options as a string array suitable for tcl eval() command.
     *
     * @return array<string>
     */
    public function toStringList(): array
    {
        $str = [];
        foreach ($this as $option => $value) {
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
                } elseif (is_object($value) && property_exists($value, 'value')) {
                    $str[] = $value->value;
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
     * Array options to Tcl string converter.
     */
    public static function tclString(array $options): string
    {
        return (new static($options))->toString();
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
     *
     * @throws InvalidArgumentException The list must have even number of elements.
     */
    public static function createFromList(array $list, bool $asOptions = true): static
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
