<?php declare(strict_types=1);

namespace TclTk\Widgets;

use InvalidArgumentException;
use SplObserver;
use SplSubject;
use TclTk\Options;

/**
 * Implementation of Ttk notebook widget.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_notebook.htm
 *
 * @property int $height
 * @property string $padding TODO: must be list of integers ?
 * @property int $width
 */
class Notebook extends TtkWidget implements SplObserver
{
    protected string $widget = 'ttk::notebook';
    protected string $name = 'nbk';

    /** @var NotebookTab[] */
    private array $tabs = [];

    /**
     * @inheritdoc
     */
    protected function initWidgetOptions(): Options
    {
        return new Options([
            'height' => null,
            'padding' => null,
            'width' => null,
        ]);
    }

    /**
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_notebook.htm#M20
     */
    public function add(NotebookTab $tab): self
    {
        $this->tabs[] = $tab;
        $this->call('add', $tab->container()->path(), ...$tab->options()->asStringArray());
        $tab->attach($this);
        return $this;
    }

    /**
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_notebook.htm#M34
     *
     * @return NotebookTab[]
     */
    public function tabs(): array
    {
        return $this->tabs;
    }

    /**
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_notebook.htm#M31
     *
     * @param int|NotebookTab $index
     */
    public function select($index): self
    {
        if ($index instanceof NotebookTab) {
            $index = $this->index($index);
        }
        $this->call('select', $index);
        return $this;
    }

    /**
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_notebook.htm#M24
     *
     * @param int|NotebookTab $index
     */
    public function hide($index): self
    {
        if ($index instanceof NotebookTab) {
            $index = $this->index($index);
        }
        $this->call('hide', $index);
        return $this;
    }

    /**
     * Updates the tab's options.
     */
    public function update(SplSubject $subject): void
    {
        if (($index = array_search($subject, $this->tabs, true)) === false) {
            return;
        }
        $tab = $this->tabs[$index];
        $this->call('tab', $index, ...$tab->options()->asStringArray());
    }

    /**
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_notebook.htm#M23
     *
     * @param int|NotebookTab $index
     */
    public function forget($index): self
    {
        if ($index instanceof NotebookTab) {
            $index = $this->index($index);
        }
        $tab = $this->tab($index);
        $tab->detach($this);

        $this->call('forget', $index);

        unset($this->tabs[$index]);

        return $this;
    }

    /**
     * Gets the tab instance by index.
     */
    public function tab(int $index): NotebookTab
    {
        if (! isset($this->tabs[$index])) {
            throw new InvalidArgumentException('Index is out of range.');
        }
        return $this->tabs[$index];
    }

    /**
     * Gets the tab index.
     */
    public function index(NotebookTab $tab): int
    {
        $index = array_search($tab, $this->tabs, true);
        if ($index === false) {
            throw new InvalidArgumentException('Tab not found.');
        }
        return $index;
    }
}