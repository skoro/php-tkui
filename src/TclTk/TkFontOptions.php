<?php declare(strict_types=1);

namespace PhpGui\TclTk;

use PhpGui\Options;

/**
 * @property string $family
 * @property int $size
 * @property string $weight
 * @property string $slant
 * @property bool $underline
 * @property bool $overstrike
 */
class TkFontOptions extends Options
{
    public function __construct(array $options = [])
    {
        parent::__construct($this->defaults());
        $this->mergeAsArray($options);
    }

    protected function defaults(): array
    {
        return [
            'family' => null,
            'size' => null,
            'weight' => null,
            'slant' => null,
            'underline' => null,
            'overstrike' => null,
        ];
    }
}