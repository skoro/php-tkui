<?php declare(strict_types=1);

namespace PhpGui\Tests\Widgets;

use PhpGui\Tests\TestCase;
use PhpGui\Widgets\LabelFrame;

class LabelFrameTest extends TestCase
{
    /** @test */
    public function widget_created()
    {
        $this->tclEvalTest(1, [
            ['ttk::labelframe', $this->checkWidget('.lbf'), '-text', '{Frame with label}'],
        ]);

        new LabelFrame($this->createWindowStub(), 'Frame with label');
    }
}