<?php declare(strict_types=1);

namespace PhpGui\Widgets\Menu;

use PhpGui\Options;

abstract class CommonItem
{
    private Options $options;
    private int $id;

    // TODO: id generator ?
    private static int $idIterator = 0;

    public function __construct(array $options = [])
    {
        $this->id = static::generateId();
        $this->options = $this->createOptions()
                              ->mergeAsArray($options);
    }

    private static function generateId(): int
    {
        return ++static::$idIterator;
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

    public function id(): int
    {
        return $this->id;
    }
}