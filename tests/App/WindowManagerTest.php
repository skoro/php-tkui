<?php declare(strict_types=1);

namespace TclTk\Tests\App;

use TclTk\Tests\TestCase;
use TclTk\Windows\MainWindow;

class WindowManagerTest extends TestCase
{
    protected function tclEvalTest(int $count, $args)
    {
        return $this->app
            ->expects($this->exactly($count))
            ->method('tclEval')
            ->withConsecutive(...$args)->willReturn('');
    }

    /** @test */
    public function window_title_via_wm()
    {
        $this->tclEvalTest(1, [
            ['wm', 'title', '.', '{Test}'],
        ]);

        new MainWindow($this->app, 'Test');
    }

    /** @test */
    public function window_set_state()
    {
        $this->tclEvalTest(2, [
            ['wm', 'title', '.', '{State Test}'],
            ['wm', 'state', '.', 'zoomed'],
        ]);

        (new MainWindow($this->app, 'State Test'))
            ->getWindowManager()
            ->setState('zoomed');
    }

    /** @test */
    public function window_get_state()
    {
        $this->tclEvalTest(2, [
            ['wm', 'title', '.', '{State Test}'],
            ['wm', 'state', '.'],
        ]);

        (new MainWindow($this->app, 'State Test'))
            ->getWindowManager()
            ->getState();
    }

    /** @test */
    public function iconify_window()
    {
        $this->tclEvalTest(2, [
            ['wm', 'title', '.', '{Iconify Test}'],
            ['wm', 'iconify', '.'],
        ]);

        (new MainWindow($this->app, 'Iconify Test'))
            ->getWindowManager()
            ->iconify();
    }

    /** @test */
    public function deiconify_window()
    {
        $this->tclEvalTest(2, [
            ['wm', 'title', '.', '{Deiconify Test}'],
            ['wm', 'deiconify', '.'],
        ]);

        (new MainWindow($this->app, 'Deiconify Test'))
            ->getWindowManager()
            ->deiconify();
    }

    /** @test */
    public function set_window_maximum_size()
    {
        $this->tclEvalTest(2, [
            ['wm', 'title', '.', '{Max Test}'],
            ['wm', 'maxsize', '.', '100', '160'],
        ]);

        (new MainWindow($this->app, 'Max Test'))
            ->getWindowManager()
            ->setMaxSize(100, 160);
    }

    /** @test */
    public function set_window_minimum_size()
    {
        $this->tclEvalTest(2, [
            ['wm', 'title', '.', '{Min Test}'],
            ['wm', 'minsize', '.', '800', '600'],
        ]);

        (new MainWindow($this->app, 'Min Test'))
            ->getWindowManager()
            ->setMinSize(800, 600);
    }

    /** @test */
    public function switch_window_to_fullscreen()
    {
        $this->tclEvalTest(2, [
            ['wm', 'title', '.', '{Fullscreen Test}'],
            ['wm', 'attributes', '.', '-fullscreen', '1'],
        ]);

        (new MainWindow($this->app, 'Fullscreen Test'))
            ->getWindowManager()
            ->setFullScreen();
    }

    /** @test */
    public function set_window_attribute_value()
    {
        $this->tclEvalTest(2, [
            ['wm', 'title', '.', '{Attribute Test}'],
            ['wm', 'attributes', '.', '-name', 'value'],
        ]);

        (new MainWindow($this->app, 'Attribute Test'))
            ->getWindowManager()
            ->setAttribute('name', 'value');
    }
}