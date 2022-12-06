<?php

declare(strict_types=1);

namespace Tkui\Widgets\TreeView;

use Tkui\Options;
use Tkui\TclTk\TclOptions;
use Tkui\Widgets\Common\SubjectItem;
use Tkui\Widgets\Consts\Anchor;

/**
 * @property string $id
 * @property Anchor $anchor
 * @property int $minWidth
 * @property bool $stretch
 * @property int $width
 */
class Column extends SubjectItem
{
    private Header $header;

    final public function __construct(string $id, Header $header, array|Options $options = [])
    {
        parent::__construct($options);
        $this->id = $id;
        $this->header = $header;
    }

    protected function createOptions(): Options
    {
        return new TclOptions([
            'id' => null,
            'anchor' => null,
            'minWidth' => null,
            'stretch' => null,
            'width' => null,
        ]);
    }

    public function header(): Header
    {
        return $this->header;
    }

    public static function create(string $id, string $header): static
    {
        return new static($id, new Header($header));
    }
}
