<?php declare(strict_types=1);

namespace TclTk\Tests\Widgets;

use TclTk\Tests\TestCase;
use TclTk\Widgets\Sizegrip;

class SizegripTest extends TestCase
{
    /** @test */
    public function widget_created()
    {
        $this->tclEvalTest(1, [
            ['ttk::sizegrip', $this->checkWidget('.szg')],
        ]);

        new Sizegrip($this->createWindowStub());
    }
}