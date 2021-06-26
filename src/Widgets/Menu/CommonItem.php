<?php declare(strict_types=1);

namespace PhpGui\Widgets\Menu;

use PhpGui\Options;

abstract class CommonItem
{
    private Options $options;

    public function __construct(array $options = [])
    {
        $this->options = $this->createOptions()
                              ->mergeAsArray($options);
    }

    protected function createOptions(): Options
    {
        return new Options();
    }

    public function __set($name, $value)
    {
        $this->options->$name = $value;
    }

    public function __get($name)
    {
        return $this->options->$name;
    }

    abstract public function type(): string;

    public function options(): Options
    {
        return $this->options;
    }
}