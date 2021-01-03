<?php declare(strict_types=1);

namespace TclTk\Tests\Widgets;

use TclTk\Tests\TestCase;
use TclTk\Widgets\Window;

class WindowTest extends TestCase
{
    /** @test */
    public function root_window()
    {
        $this->tclEvalTest(1, [
            ['wm', 'title', '.', '{Test}']
        ]);
        new Window($this->app, 'Test');
    }

    /** @test */
    public function second_window()
    {
        // Because of static window's id all subsequent windows
        // will be created throughout of toplevel.
        $this->tclEvalTest(4, [
            ['toplevel', $this->checkWidget('.w')],
            ['wm', 'title', $this->checkWidget('.w'), '{Win 1}'],
            ['toplevel', $this->checkWidget('.w')],
            ['wm', 'title', $this->checkWidget('.w'), '{Win 2}'],
        ]);
        new Window($this->app, 'Win 1');
        new Window($this->app, 'Win 2');
    }
}