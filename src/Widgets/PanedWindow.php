<?php declare(strict_types=1);

namespace TclTk\Widgets;

use TclTk\Exceptions\TkException;
use TclTk\Options;

/**
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_panedwindow.htm
 *
 * @property string $orient
 * @property int $width
 * @property int $height
 */
class PanedWindow extends TtkWidget
{
    /**
     * Values for 'orient' property.
     */
    const ORIENT_VERTICAL = 'vertical';
    const ORIENT_HORIZONTAL = 'horizontal';

    protected string $widget = 'ttk::panedwindow';
    protected string $name = 'pnw';

    /**
     * @inheritdoc
     */
    protected function initWidgetOptions(): Options
    {
        return new Options([
            'orient' => null,
            'width' => null,
            'height' => null,
        ]);
    }

    public function add(Widget $widget, int $weight = 0): self
    {
        $this->checkWidgetParent($widget);
        $this->call('add', $widget->path());
        return $this;
    }

    /**
     * @param Widget|int $widget
     * 
     * @todo Use union types in PHP 8.
     */
    public function forget($widget): self
    {
        if ($widget instanceof Widget) {
            $this->checkWidgetParent($widget);
            $widget = $widget->path();
        }
        elseif (!is_int($widget)) {
            throw new TkException('Must be widget instance or numeric index of a pane.');
        }
        $this->call('forget', $widget);
        return $this;
    }

    /**
     * @throws TkException When the widget is not a child of the paned window.
     */
    protected function checkWidgetParent(Widget $widget): void
    {
        if ($widget->parent() !== $this) {
            throw new TkException('Widget must be a child of the panedwindow.');
        }
    }

    public function insert(int $pos, Widget $widget, int $weight = 0): self
    {
        $this->checkWidgetParent($widget);
        $this->call('insert', $pos, $widget->path(), '-weight', $weight);
        return $this;
    }
}