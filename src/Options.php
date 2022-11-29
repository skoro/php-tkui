<?php declare(strict_types=1);

namespace Tkui;

use ArrayIterator;
use IteratorAggregate;
use JsonSerializable;
use Stringable;
use Tkui\Exceptions\OptionNotFoundException;
use Traversable;

/**
 * Implements dynamic option-value class.
 */
class Options implements Stringable, JsonSerializable, IteratorAggregate
{
    /** @var array<string, mixed> */
    private array $options;

    public function __construct(array $options = [])
    {
        $this->options = $options;
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

    protected function toString(): string
    {
        return implode(', ', $this->names());
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
}
