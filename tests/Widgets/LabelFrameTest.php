<?php declare(strict_types=1);

namespace TclTk\Tests\Widgets;

use TclTk\Tests\TestCase;
use TclTk\Widgets\LabelFrame;

class LabelFrameTest extends TestCase
{
    /** @test */
    public function widget_created()
    {
        $this->tclEvalTest(1, [
            ['labelframe', $this->checkWidget('.lbf'), '-text', '{Frame with label}'],
        ]);

        new LabelFrame($this->createWindowStub(), 'Frame with label');
    }
}