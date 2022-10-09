<?php

declare(strict_types=1);

namespace Tkui\Widgets\TreeView;

use Tkui\Options;

/**
 * @property string $anchor
 * @property int $minWidth
 * @property bool $stretch
 * @property int $width
 */
class Column
{
    private Options $options;

    public function __construct(array $options = [])
    {
        $this->options = $this->createOptions()->mergeAsArray($options);
    }

    protected function createOptions(): Options
    {
        return new Options([
            'anchor' => null,
            'minWidth' => null,
            'stretch' => null,
            'width' => null,
        ]);
    }
}
