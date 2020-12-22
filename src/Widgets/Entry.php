<?php declare(strict_types=1);

namespace TclTk\Widgets;

use TclTk\Options;

/**
 * Implementation of Tk entry widget.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/entry.htm
 */
class Entry extends Widget
{
    public function __construct(TkWidget $parent, array $options = [])
    {
        parent::__construct($parent, 'entry', 'e', $options);
    }

    /**
     * @inheritdoc
     */
    protected function initWidgetOptions(): Options
    {
        return new Options([
            'disabledBackground' => null,
            'disabledForeground' => null,
            'invalidCommand' => null,
            'readonlyBackground' => null,
            'show' => null,
            'state' => null,
            'validate' => null,
            'validateCommand' => null,
            'width' => null,
        ]);
    }

    /**
     * Returns the entry's string.
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/entry.htm#M45
     */
    public function value(): string
    {
        return $this->exec('get');
    }

    /**
     * Delete one or more elements of the entry.
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/entry.htm#M44
     */
    public function delete(int $first, int $last = 0): self
    {
        $params = ['delete', $first];
        if ($last > 0) {
            $params[] = $last;
        }
        $this->exec($params);
        return $this;
    }

    /**
     * Insert a string just before the specified index.
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/entry.htm#M48
     */
    public function insert(int $index, string $str): self
    {
        $this->exec(['insert', $index, $str]);
        return $this;
    }
}