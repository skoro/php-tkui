<?php

declare(strict_types=1);

namespace Tkui\Tests\App;

use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use Tkui\TclTk\Interp;
use Tkui\TclTk\Tk;
use Tkui\TclTk\TkApplication;
use Tkui\Tests\TestCase;

class TkApplicationTest extends TestCase
{
    /** @test */
    public function it_issues_tcl_command_to_check_gui_type(): void
    {
        /** @var MockObject|Interp */
        $interpMock = $this->createMock(Interp::class);
        $interpMock
            ->expects($this->once())
            ->method('eval')
            ->with('tk windowingsystem');
        $interpMock
            ->expects($this->once())
            ->method('getStringResult')
            ->willReturn('x11');

        /** @var Stub|Tk */
        $tkStub = $this->createStub(Tk::class);
        $tkStub->method('interp')->willReturn($interpMock);

        (new TkApplication($tkStub))->getGuiType();
    }

    /** @test */
    public function it_throws_exception_when_gui_type_is_unknown(): void
    {
        /** @var MockObject|Interp */
        $interpMock = $this->createMock(Interp::class);
        $interpMock
            ->expects($this->once())
            ->method('getStringResult')
            ->willReturn('Some unsupported gui type');

        /** @var Stub|Tk */
        $tkStub = $this->createStub(Tk::class);
        $tkStub->method('interp')->willReturn($interpMock);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Not supported gui type:');

        (new TkApplication($tkStub))->getGuiType();
    }
}
