<?php

declare(strict_types=1);

namespace Tkui\Widgets\TreeView;

use Tkui\Image;
use Tkui\Options;
use Tkui\TclTk\TclOptions;
use Tkui\Widgets\Common\SubjectItem;
use Tkui\Widgets\Consts\Anchor;

/**
 * @property string $text
 * @property Image $image
 * @property Anchor $anchor
 * @property callable $command
 *
 * @todo Just extend from TclOptions ?
 */
class Header extends SubjectItem
{
    public function __construct(string $text, array|Options $options = [])
    {
        parent::__construct($options);
        $this->text = $text;
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
}
