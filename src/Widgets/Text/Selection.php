<?php declare(strict_types=1);

namespace Tkui\Widgets\Text;

/**
 * The text selection.
 */
class Selection extends TextStyle
{
    public function __construct(TextApiMethodBridge $selectionBridge)
    {
        parent::__construct($selectionBridge, 'sel');
    }

    /**
     * The selection range.
     */
    public function range(): ?Range
    {
        if (! ($ranges = $this->ranges())) {
            return null;
        }
        return $ranges[0];
    }
}