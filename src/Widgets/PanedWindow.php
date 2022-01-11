<?php declare(strict_types=1);

namespace Tkui\Widgets;

use Tkui\Options;
use Tkui\Widgets\Consts\Orient;
use Tkui\Widgets\Exceptions\WidgetException;

/**
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_panedwindow.htm
 *
 * @property string $orient By default, vertical orientation.
 * @property int $width
 * @property int $height
 */
class PanedWindow extends TtkContainer implements Orient
{
    protected string $widget = 'ttk::panedwindow';
    protected string $name = 'pnw';

    /**
     * @inheritdoc
     */
    protected function initWidgetOptions(): Options
    {
        return new Options([
            'orient' => self::ORIENT_VERTICAL,
            'width' => null,
            'height' => null,
        ]);
    }

    public function add(Container $widget, int $weight = 0): self
    {
        $this->checkWidgetParent($widget);
        $this->call('add', $widget->path(), '-weight', $weight);
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
            throw new WidgetException($this, 'Must be widget instance or numeric index of a pane.');
        }
        $this->call('forget', $widget);
        return $this;
    }

    /**
     * @throws WidgetException When the widget is not a child of the paned window.
     */
    protected function checkWidgetParent(Widget $widget): void
    {
        if ($widget->parent() !== $this) {
            throw new WidgetException($this, 'Widget must be a child of the panedwindow.');
        }
    }

    public function insert(int $pos, Widget $widget, int $weight = 0): self
    {
        $this->checkWidgetParent($widget);
        $this->call('insert', $pos, $widget->path(), '-weight', $weight);
        return $this;
    }
}