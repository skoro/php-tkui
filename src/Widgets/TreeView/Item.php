<?php

declare(strict_types=1);

namespace Tkui\Widgets\TreeView;

use LogicException;
use Tkui\Image;
use Tkui\Options;
use Tkui\TclTk\TclOptions;
use Tkui\Widgets\Common\SubjectItem;

/**
 * @todo make id property real readonly.
 *
 * @property string $id (readonly)
 * @property string $text
 * @property string[] $values
 * @property Image $image
 * @property bool $open
 * @property string[] $tags
 *
 * @todo Just extend from TclOptions ?
 */
class Item extends SubjectItem
{
    /**
     * @param string[] $values
     */
    final public function __construct(array $values = [], array|Options $options = [])
    {
        parent::__construct($options);
        $this->values = $values;
    }

    protected function createOptions(): Options
    {
        return new TclOptions([
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
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        if ($name === 'id') {
            throw new LogicException('"id" property is readonly.');
        }

        parent::__set($name, $value);
    }

    public static function values(array $values): static
    {
        return new static($values);
    }
}
