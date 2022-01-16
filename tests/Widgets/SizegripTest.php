<?php declare(strict_types=1);

namespace Tkui\Tests\Widgets;

use Tkui\Tests\TestCase;
use Tkui\Widgets\Sizegrip;

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