<?php declare(strict_types=1);

namespace TclTk\Tests;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase as FrameworkTestCase;
use TclTk\App;
use TclTk\FFILoader;
use TclTk\Tcl;
use TclTk\Widgets\TkWidget;
use TclTk\Widgets\Window;

class TestCase extends FrameworkTestCase
{
    protected $app;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app = $this->createAppMock();
    }

    /**
     * @return App|MockObject
     */
    protected function createAppMock()
    {
        return $this->createMock(App::class);
    }

    public function createWindowStub(): TkWidget
    {
        /** @var Window|Stub $win */
        $win = $this->createStub(Window::class);
        $win->method('app')->willReturn($this->app);
        $win->method('window')->willReturnSelf();
        return $win;
    }

    protected function checkWidget(string $name)
    {
        return $this->stringStartsWith($name);
    }

    protected function tclEvalTest(int $count, $args)
    {
        return $this->app
            ->expects($this->exactly($count))
            ->method('tclEval')
            ->withConsecutive(...$args);
    }

    protected function createTcl(string $ver = '86'): Tcl
    {
        $loader = new FFILoader();
        return new Tcl($loader->loadTcl("tcl{$ver}.h"));
    }
}
