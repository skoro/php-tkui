<?php declare(strict_types=1);

namespace Tkui\Tests\Widgets;

use Tkui\Tests\TestCase;
use Tkui\Widgets\Consts\Orient;
use Tkui\Widgets\PanedWindow;

class PanedWindowTest extends TestCase
{
    /** @test */
    public function it_creates_paned_window_widget(): void
    {
        $this->tclEvalTest(1, [
            ['ttk::panedwindow', $this->checkWidget('.pnw'), '-orient', 'vertical']
        ]);

        new PanedWindow($this->createWindowStub());
    }

    /** @test */
    public function it_creates_paned_horizontal(): void
    {
        $this->tclEvalTest(1, [
            ['ttk::panedwindow', $this->checkWidget('.pnw'), '-orient', 'horizontal']
        ]);

        new PanedWindow($this->createWindowStub(), ['orient' => Orient::HORIZONTAL]);
    }
}
