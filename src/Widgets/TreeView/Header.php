<?php

declare(strict_types=1);

namespace Tkui\Widgets\TreeView;

use Tkui\Image;
use Tkui\Options;
use Tkui\TclTk\TclOptions;
use Tkui\Widgets\Consts\Anchor;

/**
 * @property string $text
 * @property Image $image
 * @property Anchor $anchor
 * @property callable $command
 *
 * @todo Just extend from TclOptions ?
 */
class Header
{
    private Options $options;

    public function __construct(string $text, array|Options $options = [])
    {
        $this->options = $this->createOptions()->with($options + [
            'text' => $text,
        ]);
    }

    protected function createOptions(): Options
    {
        return new TclOptions([
            'text' => null,
            'image' => null,
            'anchor' => null,
            'command' => null,
        ]);
    }

    public function options(): Options
    {
        return $this->options;
    }
    /**
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->options->$name;
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        $this->options->$name = $value;
    }
}