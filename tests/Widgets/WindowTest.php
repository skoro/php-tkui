<?php declare(strict_types=1);

namespace PhpGui\Tests\Widgets;

use PhpGui\Tests\TestCase;
use PhpGui\Windows\ChildWindow;
use PhpGui\Windows\MainWindow;

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
}