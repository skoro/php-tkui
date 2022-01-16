<?php declare(strict_types=1);

namespace Tkui\Widgets;

use InvalidArgumentException;
use SplObserver;
use SplSubject;
use Tkui\Options;

/**
 * Implementation of Ttk notebook widget.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_notebook.htm
 *
 * @property int $height
 * @property string $padding
 * @property int $width
 */
// TODO: $padding must be list of integers ?
class Notebook extends TtkContainer implements SplObserver
{
    protected string $widget = 'ttk::notebook';
    protected string $name = 'nbk';

    /** @var NotebookTab[] */
    private array $tabs = [];

    private bool $keyboardTraversal = false;

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
        if ($tab->underline !== null) {
            $this->enableTraversal();
        }
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
     * @param int|string|NotebookTab $index Can be tab index, 'current' or tab instance.
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
     * @param int|string|NotebookTab $index Can be tab index, 'current' or tab instance.
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

    /**
     * @param callable $callback Will be executed when a new tab is selected.
     *                          The callback accepts two parameters:
     *                          the tab instance and notebook widget.
     */
    public function onChanged(callable $callback): self
    {
        $this->bind('<<NotebookTabChanged>>', function () use ($callback) {
            $index = (int) $this->call('index', 'current');
            $callback($this->tab($index), $this);
        });
        return $this;
    }

    /**
     * Enables keyboard traversal for the widget.
     *
     * ALT-K bindings will be activated for accessing an arbitrary tab.
     */
    public function enableTraversal(): self
    {
        if (! $this->keyboardTraversal) {
            $this->getEval()
                 ->tclEval('::ttk::notebook::enableTraversal', $this->path());
            $this->keyboardTraversal = true;
        }
        return $this;
    }
}