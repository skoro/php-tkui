<?php declare(strict_types=1);

namespace PhpGui\Tests\Widgets;

use PhpGui\Tests\TestCase;
use PhpGui\Widgets\Frame;

class FrameTest extends TestCase
{
    /** @test */
    public function widget_created()
    {
        $this->tclEvalTest(1, [['ttk::frame', $this->checkWidget('.f')]]);

        new Frame($this->createWindowStub());
    }
}