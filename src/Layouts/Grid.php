<?php declare(strict_types=1);

namespace Tkui\Layouts;

use Tkui\Options;
use Tkui\TclTk\TclOptions;
use Tkui\Widgets\Widget;

/**
 * grid geometry manager.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/grid.htm
 *
 * @property int $column
 * @property int $columnSpan
 * @property int $row
 * @property int $rowSpan
 */
class Grid extends BaseManager
{
    /**
     * @inheritdoc
     */
    protected function createLayoutOptions(): Options
    {
        return new TclOptions([
            'column' => null,
            'columnSpan' => null,
            'ipadx' => null,
            'ipady' => null,
            'padx' => null,
            'pady' => null,
            'row' => null,
            'rowSpan' => null,
            'sticky' => null,
        ]);
    }

    /**
     * @inheritdoc
     */
    protected function command(): string
    {
        return 'grid';
    }

    /**
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/grid.htm#M24
     */
    public function rowConfigure(Widget $widget, int $index, array|Options $options): self
    {
        return $this->configure('row', $widget, $index, $options);
    }

    /**
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/grid.htm#M8
     */
    public function columnConfigure(Widget $widget, int $index, array|Options $options): self
    {
        return $this->configure('column', $widget, $index, $options);
    }

    protected function configure(string $type, Widget $widget, int $index, array|Options $options): self
    {
        $cmdOptions = new TclOptions([
            'minsize' => null,
            'weight' => null,
            'uniform' => null,
            'pad' => null,
        ]);
        $this->call("{$type}configure", $widget->path(), $index, ...$cmdOptions->with($options)->toStringList());
        return $this;
    }
}
