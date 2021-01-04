<?php declare(strict_types=1);

namespace TclTk\Tests\Widgets;

use TclTk\Tests\TestCase;
use TclTk\Widgets\Buttons\RadioButton;

class RadioButtonTest extends TestCase
{
    /** @test */
    public function widget_created()
    {
        $this->tclEvalTest(1, [
            ['radiobutton', $this->checkWidget('.rb')],
        ]);

        new RadioButton($this->createWindowStub());
    }
}