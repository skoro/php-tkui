<?php declare(strict_types=1);

namespace Tkui\Widgets;

use Tkui\Color;
use Tkui\Options;
use Tkui\TclTk\TclOptions;
use Tkui\Widgets\Common\SubjectItem;

/**
 * Listbox widget item.
 *
 * @property Color|string $background
 * @property Color|string $foreground
 * @property Color|string $selectBackground
 * @property Color|string $selectForeground
 *
 * @todo Just extend from TclOptions ?
 */
class ListboxItem extends SubjectItem
{
    private string $value;

    public function __construct(string $value, array|Options $options = [])
    {
        parent::__construct($options);
        $this->value = $value;
    }

    /**
     * Item options.
     */
    protected function createOptions(): Options
    {
        return new TclOptions([
            'background' => null,
            'foreground' => null,
            'selectBackground' => null,
            'selectForeground' => null,
        ]);
    }

    public function value(): string
    {
        return $this->value;
    }
}
