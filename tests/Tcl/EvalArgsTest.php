<?php declare(strict_types=1);

namespace Tkui\Tests\Tcl;

use Tkui\TclTk\Interp;
use Tkui\TclTk\Tk;
use Tkui\TclTk\TkApplication;
use Tkui\Tests\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class EvalArgsTest extends TestCase
{
    /** @var Interp|MockObject */
    private $interp;

    /** @var Tk|MockObject */
    private $tk;

    protected function setUp(): void
    {
        parent::setUp();

        $this->interp = $this->createMock(Interp::class);

        $this->tk = $this->createMock(Tk::class);
        $this->tk->method('interp')->willReturn($this->interp);

        $this->app = new TkApplication($this->tk);
    }

    /** @test */
    public function eval_arguments_with_space_must_be_quoted()
    {
        $this->interp
            ->expects($this->once())
            ->method('eval')
            ->with('command method {list of data}');

        $this->app->tclEval('command', 'method', 'list of data');
    }

    /** @test */
    public function dont_quote_one_word_arg()
    {
        $this->interp
            ->expects($this->once())
            ->method('eval')
            ->with('command method data');

        $this->app->tclEval('command', 'method', 'data');
    }

    /** @test */
    public function skip_already_double_quoted_string()
    {
        $this->interp->expects($this->once())
            ->method('eval')
            ->with('command method "data"');

        $this->app->tclEval('command', 'method', '"data"');
    }

    /** @test */
    public function skip_already_single_quoted_string()
    {
        $this->interp->expects($this->once())
            ->method('eval')
            ->with("command method 'data data'");

        $this->app->tclEval('command', 'method', "'data data'");
    }

    /** @test */
    public function brackets1()
    {
        $this->interp->expects($this->once())
            ->method('eval')
            ->with('command method {data data}');

        $this->app->tclEval('command', 'method', '{data data}');
    }

    /** @test */
    public function brackets2()
    {
        $this->interp->expects($this->once())
            ->method('eval')
            ->with('command method [data data]');

        $this->app->tclEval('command', 'method', '[data data]');
    }

    /** @test */
    public function newline_char_inside_string()
    {
        $this->interp->expects($this->once())
            ->method('eval')
            ->with('command method ' . "{line\n}");

        $this->app->tclEval('command', 'method', "line\n");
    }
}