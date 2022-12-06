<?php

declare(strict_types=1);

namespace Tkui\Widgets\Common;

use SplSubject;
use Tkui\Options;
use Tkui\Support\WithObservable;
use Tkui\TclTk\TclOptions;

/**
 * Subject Item.
 *
 * Subject item allows to be an options instance with observable feature.
 */
class SubjectItem implements SplSubject
{
    use WithObservable;

    private Options $options;

    public function __construct(array|Options $options)
    {
        $this->options = $this->createOptions()->with($options);
    }

    protected function createOptions(): Options
    {
        return new TclOptions();
    }

    public function __get($name)
    {
        return $this->options->$name;
    }

    public function __set($name, $value)
    {
        $this->options->$name = $value;
        $this->notify();
    }

    public function options(): Options
    {
        return $this->options;
    }
}
