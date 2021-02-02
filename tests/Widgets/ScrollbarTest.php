<?php declare(strict_types=1);

namespace TclTk\Tests\Widgets;

use PHPUnit\Framework\MockObject\Stub;
use TclTk\Tests\TestCase;
use TclTk\Widgets\ScrollableWidget;
use TclTk\Widgets\Scrollbar;

class ScrollbarTest extends TestCase
{
    /** @test */
    public function vertical_orient_by_default()
    {
        $this->tclEvalTest(1, [
            ['ttk::scrollbar', $this->checkWidget('.scr'), '-orient', 'vertical'],
        ]);
        new Scrollbar($this->createWindowStub());
    }

    /** @test */
    public function create_horizontal_orient()
    {
        $this->tclEvalTest(1, [
            ['ttk::scrollbar', $this->checkWidget('.scr'), '-orient', 'horizontal'],
        ]);
        new Scrollbar($this->createWindowStub(), FALSE);
    }

    /** @test */
    public function vert_orient_to_view()
    {
        $scr = new Scrollbar($this->createWindowStub(), TRUE);
        $this->assertEquals('yview', $scr->getOrientToView());
    }

    /** @test */
    public function horiz_orient_to_view()
    {
        $scr = new Scrollbar($this->createWindowStub(), FALSE);
        $this->assertEquals('xview', $scr->getOrientToView());
    }

    /** @test */
    public function assign_scrollable_as_vertical()
    {
        /** @var ScrollableWidget|Stub */
        $test = $this->createStub(ScrollableWidget::class);
        $test->method('path')->willReturn('.p');

        $scr = new Scrollbar($this->createWindowStub());
        $scr->command = $test;

        $this->assertEquals('.p yview', $scr->command);
    }

    /** @test */
    public function assign_scrollable_as_horizontal()
    {
        /** @var ScrollableWidget|Stub */
        $test = $this->createStub(ScrollableWidget::class);
        $test->method('path')->willReturn('.p');

        $scr = new Scrollbar($this->createWindowStub(), FALSE);
        $scr->command = $test;

        $this->assertEquals('.p xview', $scr->command);
    }
}