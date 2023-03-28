<?php

declare(strict_types=1);

namespace Tkui\Support;

use Tkui\Options;

/**
 * Options trait.
 *
 * Provides an easy way to add dynamic options to a class.
 */
trait WithOptions
{
    private Options $options;

    public function __construct(array|Options $options)
    {
        $this->options = $this->createOptions()->with($options);
    }
    
    /**
     * Options factory method.
     *
     * Depending on the usage descendants can change options return type.
     * For example, Tcl widgets rather would use TclOptions.
     */
    protected function createOptions(): Options
    {
        return new Options();
    }

    public function __get(string $name): mixed
    {
        return $this->options->$name;
    }

    public function __set(string $name, mixed $value)
    {
        $this->options->$name = $value;
        $this->notify();
    }

    public function options(): Options
    {
        return $this->options;
    }
}
