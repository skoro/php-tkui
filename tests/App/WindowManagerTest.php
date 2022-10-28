<?php declare(strict_types=1);

namespace Tkui\Tests\App;

use PHPUnit\Framework\MockObject\Stub;
use Tkui\TclTk\Interp;
use Tkui\TclTk\TkImage;
use Tkui\Tests\TestCase;
use Tkui\Windows\MainWindow;

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

    /** @test */
    public function set_window_size()
    {
        $this->tclEvalTest(2, [
            ['wm', 'title', '.', '{Size Test}'],
            ['wm', 'geometry', '.', '100x120'],
        ]);

        (new MainWindow($this->app, 'Size Test'))
            ->getWindowManager()
            ->setSize(100, 120);
    }

    /** @test */
    public function set_window_screen_pos()
    {
        $this->tclEvalTest(2, [
            ['wm', 'title', '.', '{Pos Test}'],
            ['wm', 'geometry', '.', '+400+200'],
        ]);

        (new MainWindow($this->app, 'Pos Test'))
            ->getWindowManager()
            ->setPos(400, 200);
    }

    /** @test */
    public function set_window_override_redirect()
    {
        $this->tclEvalTest(2, [
            ['wm', 'title', '.', '{Test}'],
            ['wm', 'overrideredirect', '.', '1'],
        ]);

        (new MainWindow($this->app, 'Test'))
            ->getWindowManager()
            ->setOverrideRedirect(true);
    }

    /** @test */
    public function can_set_window_icons(): void
    {
        $this->tclEvalTest(2, [
            ['wm', 'title', '.', '{Icon Test}'],
            ['wm', 'iconphoto', '.', 'image1', 'image2', 'image3'],
        ]);

        /** @var Interp|Stub */
        $interp = $this->createStub(Interp::class);

        (new MainWindow($this->app, 'Icon Test'))
            ->getWindowManager()
            ->setIcon(
                new TkImage($interp, 'image1'),
                new TkImage($interp, 'image2'),
                new TkImage($interp, 'image3')
            );
    }
}
