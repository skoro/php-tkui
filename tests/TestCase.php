<?php declare(strict_types=1);

namespace Tkui\Tests;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase as FrameworkTestCase;
use Tkui\Application;
use Tkui\Evaluator;
use Tkui\Widgets\Widget;
use Tkui\Windows\Window;

class TestCase extends FrameworkTestCase
{
    protected $app;
    protected $eval;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app = $this->createAppMock();
        $this->eval = $this->createEvalMock();
        $this->emptyEval();
    }

    /**
     * @return Application|MockObject
     */
    protected function createAppMock()
    {
        return $this->createMock(Application::class);
    }

    protected function createEvalMock()
    {
        return $this->createMock(Evaluator::class);
    }

    protected function createWindowStub(): Widget
    {
        /** @var Window|Stub $win */
        $win = $this->createStub(Window::class);
        $win->method('getEval')->willReturn($this->eval);
        $win->method('path')->willReturn('.');
        $win->method('window')->willReturnSelf();
        return $win;
    }

    protected function checkWidget(string $name)
    {
        return $this->stringStartsWith($name);
    }

    protected function tclEvalTest(int $count, $args)
    {
        return $this->eval
            ->expects($this->exactly($count))
            ->method('tclEval')
            ->withConsecutive(...$args)->willReturn('');
    }

    protected function emptyEval()
    {
        $this->eval->method('tclEval')->willReturn('');
    }
}
