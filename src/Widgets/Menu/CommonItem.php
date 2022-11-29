<?php declare(strict_types=1);

namespace Tkui\Widgets\Menu;

use Tkui\Options;
use SplSubject;
use Tkui\Observable;
use Tkui\TclTk\TclOptions;

/**
 * Base for a menu item.
 */
abstract class CommonItem implements SplSubject
{
    use Observable;

    private Options $options;
    private int $id;

    // TODO: id generator ?
    private static int $idIterator = 0;

    public function __construct(array|Options $options = [])
    {
        $this->id = self::generateId();
        $this->options = $this->createOptions()
                              ->with($options);
    }

    private static function generateId(): int
    {
        return ++self::$idIterator;
    }

    protected function createOptions(): Options
    {
        return new TclOptions();
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
}
