<?php declare(strict_types=1);

namespace Tkui;

use ArrayIterator;
use ArrayAccess;
use IteratorAggregate;
use JsonSerializable;
use LogicException;
use Stringable;
use Tkui\Exceptions\OptionNotFoundException;
use Traversable;

/**
 * Implements dynamic option-value class.
 *
 * @todo should it be observable via SplSubject ?
 */
class Options implements Stringable, JsonSerializable, IteratorAggregate, ArrayAccess
{
    /** @var array<string, mixed> */
    private array $options;

    final public function __construct(array $options = [])
    {
        $this->options = array_merge($this->defaults(), $options);
    }

    /**
     * Default class options.
     *
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        return [];
    }

    /**
     * @throws OptionNotFoundException When option name is not widget option.
     */
    public function __get($name)
    {
        if ($this->has($name)) {
            return $this->options[$name];
        }
        throw new OptionNotFoundException($name);
    }

    /**
     * @throws OptionNotFoundException When option name is not widget option.
     */
    public function __set($name, $value)
    {
        if ($this->has($name)) {
            $this->options[$name] = $value;
        } else {
            throw new OptionNotFoundException($name);
        }
    }

    public function toString(): string
    {
        return implode(', ', $this->names());
    }

    /**
     * @return array<string>
     */
    public function toStringList(): array
    {
        return $this->names();
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function toArray(): array
    {
        return $this->options;
    }

    /**
     * Check whether the option exist.
     */
    public function has(string $name): bool
    {
        return array_key_exists($name, $this->options);
    }

    /**
     * Constructs a new instance with merged options.
     */
    public function with(Options|array $options): static
    {
        return new static(array_merge(
            $this->options,
            is_array($options) ? $options : $options->options
        ));
    }

    /**
     * Constructs a new instance with specified option names.
     */
    public function withOnly(string ...$names): static
    {
        return new static(
            array_map(
                fn ($name) => $this->$name,
                array_combine($names, $names)
            )
        );
    }

    /**
     * Constructs a new instance without specified option names.
     *
     * @param string ...$names The option names to skip in new instance.
     */
    public function except(string ...$names): static
    {
        return new static(
            array_filter(
                $this->options,
                fn (string $name): bool => ! in_array($name, $names),
                mode: \ARRAY_FILTER_USE_KEY
            )
        );
    }

    /**
     * Returns a list of option names.
     *
     * @return array<string>
     */
    public function names(): array
    {
        return array_keys($this->options);
    }

    /**
     * @return array<mixed>
     */
    public function values(): array
    {
        return array_values($this->options);
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->options;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->options);
    }

    public static function from(array|Options $options): static
    {
        return new static(
            is_object($options) ? $options->toArray() : $options
        );
    }

    public function offsetExists(mixed $offset): bool
    {
        return $this->has((string)$offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->{$offset};
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->{$offset} = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        throw new LogicException('Option unset is not supported.');
    }
}
