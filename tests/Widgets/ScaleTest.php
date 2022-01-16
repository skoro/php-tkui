<?php declare(strict_types=1);

namespace Tkui\Tests\Widgets;

use Tkui\Tests\TestCase;
use Tkui\Widgets\Scale;

class ScaleTest extends TestCase
{
    /** @test */
    public function widget_created()
    {
        $this->tclEvalTest(1, [
            ['ttk::scale', $this->checkWidget('.sc')],
        ]);

        new Scale($this->createWindowStub());
    }
}