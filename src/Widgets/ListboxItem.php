<?php declare(strict_types=1);

namespace Tkui\Widgets;

use Tkui\Color;
use SplSubject;
use Tkui\Observable;
use Tkui\Options;

/**
 * Listbox widget item.
 *
 * @property Color|string $background
 * @property Color|string $foreground
 * @property Color|string $selectBackground
 * @property Color|string $selectForeground
 */
class ListboxItem implements SplSubject
{
    use Observable;

    private string $value;
    private Options $options;

    public function __construct(string $value, array $options = [])
    {
        $this->value = $value;
        $this->options = $this->initOptions()->mergeAsArray($options);
    }

    /**
     * Item options.
     */
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

    /**
     * Get the item option.
     */
    public function __get($name)
    {
        return $this->options->$name;
    }

    /**
     * Set the item option.
     */
    public function __set($name, $value)
    {
        $this->options->$name = $value;
        $this->notify();
    }
}
