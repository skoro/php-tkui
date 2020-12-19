<?php declare(strict_types=1);

namespace TclTk\Widgets;

use TclTk\Options;

/**
 * Implementation of Tk button widget.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/button.htm
 */
class Button extends Widget
{
    public function __construct(TkWidget $parent, string $title, array $options = [])
    {
        parent::__construct($parent, 'b', $options);
        $this->make('button');
        $this->text = $title;
    }

    public function onClick(callable $callback): self
    {
        $this->command = $this->getWindow()->registerCallback($this, $callback);
        return $this;
    }

    /**
     * @link http://www.tcl.tk/man/tcl8.6/TkCmd/button.htm#M16
     */
    public function flash(): void
    {
        // TODO 
    }

    /**
     * @link http://www.tcl.tk/man/tcl8.6/TkCmd/button.htm#M17
     */
    public function invoke(): void
    {
        // TODO
    }
}