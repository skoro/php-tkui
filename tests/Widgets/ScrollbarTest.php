<?php declare(strict_types=1);

namespace Tkui\Tests\Widgets;

use PHPUnit\Framework\MockObject\Stub;
use Tkui\Tests\TestCase;
use Tkui\Widgets\ScrollableWidget;
use Tkui\Widgets\Scrollbar;

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
        new Scrollbar($this->createWindowStub(), ['orient' => Scrollbar::ORIENT_HORIZONTAL]);
    }

    /** @test */
    public function vert_orient_to_view()
    {
        $scr = new Scrollbar($this->createWindowStub());
        $this->assertEquals('yview', $scr->getOrientToView());
    }

    /** @test */
    public function horiz_orient_to_view()
    {
        $scr = new Scrollbar($this->createWindowStub(), ['orient' => Scrollbar::ORIENT_HORIZONTAL]);
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

        $scr = new Scrollbar($this->createWindowStub(), ['orient' => Scrollbar::ORIENT_HORIZONTAL]);
        $scr->command = $test;

        $this->assertEquals('.p xview', $scr->command);
    }
}