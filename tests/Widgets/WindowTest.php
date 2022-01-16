<?php declare(strict_types=1);

namespace Tkui\Tests\Widgets;

use Tkui\Tests\TestCase;
use Tkui\Windows\ChildWindow;
use Tkui\Windows\MainWindow;

class WindowTest extends TestCase
{
    protected function tclEvalTest(int $count, $args)
    {
        return $this->app
            ->expects($this->exactly($count))
            ->method('tclEval')
            ->withConsecutive(...$args)->willReturn('');
    }

    /** @test */
    public function root_window()
    {
        $this->tclEvalTest(1, [
            ['wm', 'title', '.', '{Test}']
        ]);
        new MainWindow($this->app, 'Test');
    }

    /** @test */
    public function main_and_child_windows()
    {
        $this->tclEvalTest(3, [
            ['wm', 'title', '.', '{Win 1}'],
            ['toplevel', $this->checkWidget('.w')],
            ['wm', 'title', $this->checkWidget('.w'), '{Win 2}'],
        ]);
        $main = new MainWindow($this->app, 'Win 1');
        new ChildWindow($main, 'Win 2');
    }

    /** @test */
    public function show_as_modal()
    {
        $this->tclEvalTest(4, [
            ['wm', 'title', '.', '{Parent}'],
            ['toplevel', $this->checkWidget('.w')],
            ['wm', 'title', $this->checkWidget('.w'), '{Modal}'],
            ['grab', $this->checkWidget('.w')],
        ]);
        $parent = new MainWindow($this->app, 'Parent');
        (new ChildWindow($parent, 'Modal'))->showModal();
    }
}