<?php declare(strict_types=1);

namespace Tkui\Tests\Widgets;

use Tkui\Tests\TestCase;
use Tkui\Widgets\Separator;

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