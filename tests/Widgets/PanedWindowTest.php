<?php declare(strict_types=1);

namespace PhpGui\Tests\Widgets;

use PhpGui\Tests\TestCase;
use PhpGui\Widgets\PanedWindow;

class PanedWindowTest extends TestCase
{
    /** @test */
    public function widget_created()
    {
        $this->tclEvalTest(1, [
            ['ttk::panedwindow', $this->checkWidget('.pnw'), '-orient', 'vertical']
        ]);

        new PanedWindow($this->createWindowStub());
    }

    /** @test */
    public function paned_horizontal()
    {
        $this->tclEvalTest(1, [
            ['ttk::panedwindow', $this->checkWidget('.pnw'), '-orient', 'horizontal']
        ]);

        new PanedWindow($this->createWindowStub(), ['orient' => PanedWindow::ORIENT_HORIZONTAL]);
    }
}