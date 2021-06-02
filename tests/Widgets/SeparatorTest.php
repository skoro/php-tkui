<?php declare(strict_types=1);

namespace PhpGui\Tests\Widgets;

use PhpGui\Tests\TestCase;
use PhpGui\Widgets\Separator;

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