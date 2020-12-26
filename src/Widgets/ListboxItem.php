<?php declare(strict_types=1);

namespace TclTk\Widgets;

use TclTk\Options;

/**
 * @property string $background
 * @property string $foreground
 * @property string $selectBackground
 * @property string $selectForeground
 */
class ListboxItem
{
    private string $value;
    private Options $options;

    public function __construct(string $value, array $options = [])
    {
        $this->value = $value;
        $this->options = $this->initOptions()->mergeAsArray($options);
    }

    protected function initOptions(): Options
    {
        return new Options([
            'background' => null,
            'foreground' => null,
            'selectBackground' => null,
            'selectForeground' => null,
        ]);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function options(): Options
    {
        return $this->options;
    }

    public function __get($name)
    {
        return $this->options->$name;
    }

    public function __set($name, $value)
    {
        $this->options->$name = $value;
    }
}