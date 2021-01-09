<?php declare(strict_types=1);

namespace TclTk\Tests\Widgets;

use PHPUnit\Framework\MockObject\Stub\Stub;
use TclTk\Tests\TestCase;
use TclTk\Variable;
use TclTk\Widgets\Buttons\CheckButton;
use TclTk\Widgets\TkWidget;

class CheckButtonTest extends TestCase
{
    /** @test */
    public function widget_created()
    {
        $this->tclEvalTest(2, [
            ['checkbutton', $this->checkWidget('.chk'), '-text', '{Test}'],
            [$this->checkWidget('.chk'), 'configure', '-variable', 'var'],
        ]);

        /** @var TkWidget|Stub $win */
        $win = $this->createWindowStub();
        $varStub = $this->createStub(Variable::class);
        $varStub->method('__toString')->willReturn('var');
        $win->method('registerVar')->willReturn($varStub);

        new CheckButton($win, 'Test');
    }

    /** @test */
    public function value_toggle()
    {
        $this->tclEvalTest(3, [
            ['checkbutton', $this->checkWidget('.chk'), '-text', '{Test}'],
            [$this->checkWidget('.chk'), 'configure', '-variable', ''],
            [$this->checkWidget('.chk'), 'toggle'],
        ]);

        (new CheckButton($this->createWindowStub(), 'Test', FALSE))->toggle();
    }
}