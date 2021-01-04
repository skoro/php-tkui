<?php declare(strict_types=1);

namespace TclTk\Tests\Widgets;

use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use TclTk\Tests\TestCase;
use TclTk\Widgets\Button;
use TclTk\Widgets\Window;

class ButtonTest extends TestCase
{
    /** @test */
    public function widget_created()
    {
        $this->tclEvalTest(1, [['button', '.b1', '-text', '{Button}']]);

        new Button($this->createWindowStub(), 'Button');
    }

    /** @test */
    public function button_text_changed()
    {
        $this->tclEvalTest(2, [
            ['button', $this->checkWidget('.b'), '-text', '{New Button}'],
            [$this->checkWidget('.b'), 'configure', '-text', '{Changed}']
        ]);

        $btn = new Button($this->createWindowStub(), 'New Button');
        $btn->text = 'Changed';
    }

    /** @test */
    public function make_widget_with_options()
    {
        $this->tclEvalTest(1, [
            ['button', $this->checkWidget('.b'), '-text', '{Title}', '-state', Button::STATE_ACTIVE],
        ]);

        new Button($this->createWindowStub(), 'Title', ['state' => Button::STATE_ACTIVE]);
    }

    /** @test */
    public function register_button_command()
    {
        /** @var Window|MockObject */
        $win = $this->createMock(Window::class);
        $win->expects($this->once())
            ->method('registerCallback');
        $win->method('window')->willReturnSelf();
        
        $btn = new Button($win, 'Test');
        $btn->command = function () {};
    }

    /** @test */
    public function register_button_command_from_options()
    {
        /** @var Window|MockObject */
        $win = $this->createMock(Window::class);
        $win->expects($this->once())
            ->method('registerCallback');
        $win->method('window')->willReturnSelf();

        new Button($win, 'Test', ['command' => function () {}]);
    }

    /** @test */
    public function button_command_accepts_only_callback()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('"MyCommand" is not a valid button command.');

        /** @var Window|Stub */
        $win = $this->createStub(Window::class);

        $btn = new Button($win, 'Test');
        $btn->command = 'MyCommand';
    }
}