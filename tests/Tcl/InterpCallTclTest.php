<?php

declare(strict_types=1);

namespace Tkui\Tests\Tcl;

use FFI;
use FFI\CData;
use PHPUnit\Framework\MockObject\MockObject;
use Tkui\TclTk\Exceptions\TclException;
use Tkui\TclTk\Interp;
use Tkui\TclTk\Tcl;
use Tkui\Tests\TestCase;

class InterpCallTclTest extends TestCase
{
    private CData $cdata;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cdata = FFI::new('int');
    }

    /** @test */
    public function it_redirects_unknown_method_to_underlying_tcl(): void
    {
        /** @var MockObject|Tcl */
        $tclMock = $this->createMock(Tcl::class);
        $tclMock->expects($this->once())
            ->method('createStringObj')
            ->with('foo')
            ->willReturn(FFI::new('char*'));

        $interp = new Interp($tclMock, $this->cdata);
        $interp->callTcl('createStringObj', 'foo');
    }

    /** @test */
    public function it_replaces_first_argument_to_calling_interp(): void
    {
        /** @var MockObject|Tcl */
        $tclMock = $this->createMock(Tcl::class);

        $interp = new Interp($tclMock, $this->cdata);

        $testObj = FFI::new('char*');

        $tclMock->expects($this->once())
            ->method('getIntFromObj')
            ->with($interp, $testObj)
            ->willReturn(random_int(1, 99999));

        $interp->callTcl('getIntFromObj', $testObj);
    }

    /** @test */
    public function it_throws_exception_when_it_cannot_find_method_in_tcl(): void
    {
        /** @var MockObject|Tcl */
        $tclMock = $this->createMock(Tcl::class);

        $this->expectException(TclException::class);
        $this->expectExceptionMessage('Method "somethingThatNotExistInTcl" not found in tcl api.');

        $interp = new Interp($tclMock, $this->cdata);
        $interp->callTcl('somethingThatNotExistInTcl');
    }
}