<?php declare(strict_types=1);

namespace Tkui\Widgets;

use Tkui\Color;
use SplObserver;
use SplSubject;
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
    private string $value;
    private Options $options;

    /** @var SplObserver[] */
    private array $observers;

    public function __construct(string $value, array $options = [])
    {
        $this->observers = [];
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

    public function attach(SplObserver $observer): void
    {
        $this->observers[] = $observer;
    }

    public function detach(SplObserver $observer): void
    {
        $index = array_search($observer, $this->observers, true);
        if ($index !== false) {
            unset($this->observers[$index]);
        }
    }

    public function notify(): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }
}