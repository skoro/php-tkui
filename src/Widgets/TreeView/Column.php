<?php

declare(strict_types=1);

namespace Tkui\Widgets\TreeView;

use Tkui\Options;

/**
 * @property string $id
 * @property string $anchor
 * @property int $minWidth
 * @property bool $stretch
 * @property int $width
 */
class Column
{
    private Options $options;
    private Header $header;

    final public function __construct(string $id, Header $header, array $options = [])
    {
        $options['id'] = $id;
        $this->header = $header;
        $this->options = $this->createOptions()->mergeAsArray($options);
    }

    protected function createOptions(): Options
    {
        return new Options([
            'id' => null,
            'anchor' => null,
            'minWidth' => null,
            'stretch' => null,
            'width' => null,
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

    public function header(): Header
    {
        return $this->header;
    }

    public static function create(string $id, string $header): self
    {
        return new static($id, new Header($header));
    }
}
