<?php declare(strict_types=1);

namespace Tkui\Tests\Widgets;

use Tkui\Tests\TestCase;
use Tkui\Widgets\Frame;

class FrameTest extends TestCase
{
    /** @test */
    public function widget_created()
    {
        $this->tclEvalTest(1, [['ttk::frame', $this->checkWidget('.f')]]);

        new Frame($this->createWindowStub());
    }
}