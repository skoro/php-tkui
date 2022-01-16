<?php declare(strict_types=1);

namespace Tkui\Tests\Widgets;

use Tkui\Tests\TestCase;
use Tkui\Widgets\Frame;
use Tkui\Widgets\Notebook;
use Tkui\Widgets\NotebookTab;

class NotebookTest extends TestCase
{
    /** @test */
    public function notebook_is_created()
    {
        $this->tclEvalTest(1, [['ttk::notebook', $this->checkWidget('.nbk')]]);

        new Notebook($this->createWindowStub());
    }

    /** @test */
    public function add_tab()
    {
        $this->tclEvalTest(3, [
            ['ttk::notebook', $this->checkWidget('.nbk')],
            ['ttk::frame'],
            [$this->checkWidget('.nbk'), 'add'],
        ]);

        $nb = new Notebook($this->createWindowStub());
        $tab = new NotebookTab(new Frame($nb), 'Tab');
        $this->assertCount(0, $nb->tabs());
        $nb->add($tab);
        $this->assertCount(1, $nb->tabs());
    }

    /** @test */
    public function select_tab()
    {
        $this->tclEvalTest(5, [
            ['ttk::notebook', $this->checkWidget('.nbk')],
            ['ttk::frame'],
            [$this->checkWidget('.nbk'), 'add'],
            [$this->checkWidget('.nbk'), 'select', 0],
            [$this->checkWidget('.nbk'), 'select', 0],
        ]);

        $nb = new Notebook($this->createWindowStub());
        $tab = new NotebookTab(new Frame($nb), 'Tab');
        $nb->add($tab);
        $nb->select($tab);
        $nb->select(0);
    }

    /** @test */
    public function hide_tab()
    {
        $this->tclEvalTest(5, [
            ['ttk::notebook', $this->checkWidget('.nbk')],
            ['ttk::frame'],
            [$this->checkWidget('.nbk'), 'add'],
            [$this->checkWidget('.nbk'), 'hide', 0],
            [$this->checkWidget('.nbk'), 'hide', 0],
        ]);

        $nb = new Notebook($this->createWindowStub());
        $tab = new NotebookTab(new Frame($nb), 'Tab');
        $nb->add($tab);
        $nb->hide($tab);
        $nb->hide(0);
    }

    /** @test */
    public function forget_tab_by_instance()
    {
        $this->tclEvalTest(4, [
            ['ttk::notebook', $this->checkWidget('.nbk')],
            ['ttk::frame'],
            [$this->checkWidget('.nbk'), 'add'],
            [$this->checkWidget('.nbk'), 'forget', 0],
        ]);

        $nb = new Notebook($this->createWindowStub());
        $tab = new NotebookTab(new Frame($nb), 'Tab');
        $nb->add($tab);
        $nb->forget($tab);
    }

    /** @test */
    public function forget_tab_by_index()
    {
        $this->tclEvalTest(4, [
            ['ttk::notebook', $this->checkWidget('.nbk')],
            ['ttk::frame'],
            [$this->checkWidget('.nbk'), 'add'],
            [$this->checkWidget('.nbk'), 'forget', 0],
        ]);

        $nb = new Notebook($this->createWindowStub());
        $nb->add(new NotebookTab(new Frame($nb), 'Tab'));
        $nb->forget(0);
    }

    /** @test */
    public function update_tab_property()
    {
        $this->tclEvalTest(4, [
            ['ttk::notebook', $this->checkWidget('.nbk')],
            ['ttk::frame'],
            [$this->checkWidget('.nbk'), 'add'],
            [$this->checkWidget('.nbk'), 'tab', 0, '-text', '{New tab}'],
        ]);

        $nb = new Notebook($this->createWindowStub());
        $tab = new NotebookTab(new Frame($nb), 'Tab');
        $nb->add($tab);
        $tab->text = 'New tab';
    }
}