<?php

declare(strict_types=1);

namespace Tkui\Widgets\TreeView;

use LogicException;
use Tkui\Image;
use Tkui\Options;

/**
 * @todo make id property real readonly.
 *
 * @property string $id (readonly)
 * @property string $text
 * @property string[] $values
 * @property Image $image
 * @property bool $open
 * @property string[] $tags
 */
class Item
{
    private Options $options;

    /**
     * @param string[] $values
     */
    final public function __construct(array $values = [], array $options = [])
    {
        $this->options = $this->createOptions()->mergeAsArray($options + [
            'values' => $values,
        ]);
    }

    protected function createOptions(): Options
    {
        return new Options([
            'id' => $this->generateId(),
            'text' => null,
            'values' => null,
            'image' => null,
            'open' => false,
            'tags' => null,
        ]);
    }

    private function generateId(): string
    {
        return bin2hex(random_bytes(10));
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
        if ($name === 'id') {
            throw new LogicException('"id" property is readonly.');
        }

        $this->options->$name = $value;
    }

    public function options(): Options
    {
        return $this->options;
    }

    public static function values(array $values): self
    {
        return new static($values);
    }
}