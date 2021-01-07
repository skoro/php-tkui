<?php declare(strict_types=1);

namespace TclTk\Tests\Widgets;

use PHPUnit\Framework\MockObject\Stub\Stub;
use TclTk\Tests\TestCase;
use TclTk\Variable;
use TclTk\Widgets\Buttons\RadioButton;
use TclTk\Widgets\TkWidget;

class RadioButtonTest extends TestCase
{
    /** @test */
    public function widget_created()
    {
        $this->tclEvalTest(2, [
            ['radiobutton', $this->checkWidget('.rb'), '-text', '{Radio test}'],
            [$this->checkWidget('.rb'), 'configure', '-variable', 'var'],
        ]);

        /** @var TkWidget|Stub $win */
        $win = $this->createWindowStub();
        $varStub = $this->createStub(Variable::class);
        $varStub->method('__toString')->willReturn('var');
        $win->method('registerWidgetVar')->willReturn($varStub);

        new RadioButton($win, 'Radio test');
    }
}