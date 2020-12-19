<?php declare(strict_types=1);

namespace TclTk\Widgets;

use InvalidArgumentException;
use TclTk\Options;

trait WidgetOptions
{
    private Options $options;

    public function offsetExists($offset): bool
    {
        return $this->options->has($offset);
    }

    public function offsetGet($offset)
    {
        return $this->options->$offset;
    }

    public function offsetSet($offset, $value): void
    {
        if (empty($offset)) {
            throw new InvalidArgumentException('offset parameter cannot be empty.');
        }
        $this->options->$offset = $value;
    }

    public function offsetUnset($offset): void
    {
        $this->options->$offset = null;
    }

    protected function getOptions(): Options
    {
        return $this->options;
    }
}