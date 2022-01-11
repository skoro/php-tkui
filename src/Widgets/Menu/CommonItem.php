<?php declare(strict_types=1);

namespace Tkui\Widgets\Menu;

use Tkui\Options;
use SplObserver;
use SplSubject;

/**
 * Base for a menu item.
 */
abstract class CommonItem implements SplSubject
{
    private Options $options;
    private int $id;

    /**
     * @var SplObserver[]
     */
    private array $observers;

    // TODO: id generator ?
    private static int $idIterator = 0;

    public function __construct(array $options = [])
    {
        $this->id = self::generateId();
        $this->options = $this->createOptions()
                              ->mergeAsArray($options);
        $this->observers = [];
    }

    private static function generateId(): int
    {
        return ++self::$idIterator;
    }

    protected function createOptions(): Options
    {
        return new Options();
    }

    public function __set($name, $value)
    {
        $this->options->$name = $value;
        $this->notify();
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

    // TODO: identificable interface
    public function id(): int
    {
        return $this->id;
    }

    // TODO: make a trait for observables.
    public function attach(SplObserver $observer): void
    {
        $this->observers[] = $observer;
    }

    public function detach(SplObserver $observer): void
    {
        if (($i = array_search($observer, $this->observers, true)) !== false) {
            unset($this->observers[$i]);
        }
    }

    public function notify(): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }
}