<?php declare(strict_types=1);

namespace Tkui\Tests\Widgets;

use Tkui\Tests\TestCase;
use Tkui\Widgets\LabelFrame;

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