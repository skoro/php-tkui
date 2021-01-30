<?php declare(strict_types=1);

namespace TclTk\Widgets;

use LogicException;
use TclTk\Options;

/**
 * Implementation of Tk scrollbar widget.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_scrollbar.htm
 *
 * @property string $orient
 * @property callable $command
 */
class Scrollbar extends TtkWidget
{
    const ORIENT_HORIZONTAL = 'horizontal';
    const ORIENT_VERTICAL = 'vertical';

    protected string $widget = 'ttk::scrollbar';
    protected string $name = 'scr';

    /**
     * @param bool $vert Vertical scrollbar otherwise horizontal. Same as setting 'orient' option.
     */
    public function __construct(Widget $parent, bool $vert = TRUE, array $options = [])
    {
        $options['orient'] = $vert ? self::ORIENT_VERTICAL : self::ORIENT_HORIZONTAL;
        parent::__construct($parent, $options);
    }

    /**
     * @inheritdoc
     */
    public function initWidgetOptions(): Options
    {
        return new Options([
            'command' => null,
            'orient' => null,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function __set(string $name, $value)
    {
        if ($name === 'command' && $value instanceof ScrollableWidget) {
            $value = $value->path() . ' ' . $this->getOrientToView();
        }
        parent::__set($name, $value);
    }

    /**
     * Converts the scrollbar orient option to a view name.
     */
    public function getOrientToView(): string
    {
        switch ($this->orient) {
            case self::ORIENT_HORIZONTAL:
                return 'xview';

            case self::ORIENT_VERTICAL:
                return 'yview';
        }

        throw new LogicException('Invalid orient: ' . $this->orient);
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