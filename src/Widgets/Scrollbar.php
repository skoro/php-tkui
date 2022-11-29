<?php declare(strict_types=1);

namespace Tkui\Widgets;

use LogicException;
use Tkui\Options;
use Tkui\TclTk\TclOptions;
use Tkui\Widgets\Common\Scrollable;
use Tkui\Widgets\Consts\Orient;

/**
 * Implementation of Tk scrollbar widget.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_scrollbar.htm
 *
 * @property Orient $orient By default, vertical orientation.
 * @property callable $command
 */
class Scrollbar extends TtkWidget
{
    protected string $widget = 'ttk::scrollbar';
    protected string $name = 'scr';

    /**
     * @inheritdoc
     */
    public function initWidgetOptions(): Options
    {
        return new TclOptions([
            'command' => null,
            'orient' => Orient::VERTICAL,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function __set(string $name, $value)
    {
        if ($name === 'command' && $value instanceof Scrollable) {
            $value = $value->path() . ' ' . $this->getOrientToView();
        }
        parent::__set($name, $value);
    }

    /**
     * Converts the scrollbar orient option to a view name.
     */
    public function getOrientToView(): string
    {
        return match ($this->orient) {
            Orient::HORIZONTAL => 'xview',
            Orient::VERTICAL => 'yview',
            default => throw new LogicException('Invalid orient: ' . $this->orient->value),
        };
    }

    /**
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_scrollbar.htm#M21
     */
    public function moveTo(float $fraction): self
    {
        $this->call('moveto', $fraction);
        return $this;
    }

    /**
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_scrollbar.htm#M22
     */
    public function scrollUnits(int $number): self
    {
        $this->call('scroll', $number, 'units');
        return $this;
    }

    /**
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_scrollbar.htm#M23
     */
    public function scrollPages(int $number): self
    {
        $this->call('scroll', $number, 'pages');
        return $this;
    }
}