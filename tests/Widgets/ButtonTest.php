<?php declare(strict_types=1);

namespace Tkui\Tests\Widgets;

use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use Tkui\Tests\TestCase;
use Tkui\Widgets\Buttons\Button;
use Tkui\Windows\Window;

class ButtonTest extends TestCase
{
    /** @test */
    public function widget_created()
    {
        $this->tclEvalTest(1, [['ttk::button', $this->checkWidget('.b'), '-text', '{Button}']]);

        new Button($this->createWindowStub(), 'Button');
    }

    /** @test */
    public function button_text_changed()
    {
        $this->tclEvalTest(2, [
            ['ttk::button', $this->checkWidget('.b'), '-text', '{New Button}'],
            [$this->checkWidget('.b'), 'configure', '-text', '{Changed}']
        ]);

        $btn = new Button($this->createWindowStub(), 'New Button');
        $btn->text = 'Changed';
    }

    /** @test */
    public function make_widget_with_options()
    {
        $this->tclEvalTest(1, [
            ['ttk::button', $this->checkWidget('.b'), '-text', '{Title}', '-width', 40],
        ]);

        new Button($this->createWindowStub(), 'Title', ['width' => 40]);
    }

    /** @test */
    public function register_button_command_as_property()
    {
        $eval = $this->createEvalMock();
        $eval->expects($this->once())
            ->method('registerCallback');
        $eval->method('tclEval')->willReturn('');

        /** @var Window|MockObject */
        $win = $this->createMock(Window::class);
        $win->method('getEval')->willReturn($eval);
        
        $btn = new Button($win, 'Test');
        $btn->command = function () {};
    }

    /** @test */
    public function register_button_command_as_options()
    {
        $eval = $this->createEvalMock();
        $eval->expects($this->once())
            ->method('registerCallback');
        $eval->method('tclEval')->willReturn('');

        /** @var Window|MockObject */
        $win = $this->createMock(Window::class);
        $win->method('getEval')->willReturn($eval);

        new Button($win, 'Test', ['command' => function () {}]);
    }

    /** @test */
    public function button_command_accepts_only_callback()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('"MyCommand" is not a valid button command.');

        $btn = new Button($this->createWindowStub(), 'Test');
        $btn->command = 'MyCommand'; /** @phpstan-ignore-line */
    }
}