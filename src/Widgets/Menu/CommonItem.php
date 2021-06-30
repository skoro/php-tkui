<?php declare(strict_types=1);

namespace PhpGui\Widgets\Menu;

use PhpGui\Options;
use SplObserver;
use SplSubject;

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
        $this->id = static::generateId();
        $this->options = $this->createOptions()
                              ->mergeAsArray($options);
        $this->observers = [];
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

    public function id(): int
    {
        return $this->id;
    }

    // TODO: make a trait for observables.
    public function attach(SplObserver $observer)
    {
        $this->observers[] = $observer;
    }

    public function detach(SplObserver $observer)
    {
        if (($i = array_search($observer, $this->observers, true)) !== false) {
            unset($this->observers[$i]);
        }
    }

    public function notify()
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }
}