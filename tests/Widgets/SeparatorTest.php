<?php declare(strict_types=1);

namespace TclTk\Tests\Widgets;

use TclTk\Tests\TestCase;
use TclTk\Widgets\Separator;

class SeparatorTest extends TestCase
{
    /** @test */
    public function widget_created()
    {
        $this->tclEvalTest(1, [
            ['ttk::separator', $this->checkWidget('.sep')],
        ]);

        new Separator($this->createWindowStub());
    }
}