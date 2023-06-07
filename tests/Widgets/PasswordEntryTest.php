<?php

declare(strict_types=1);

namespace Tkui\Tests\Widgets;

use PHPUnit\Framework\MockObject\Stub\Stub;
use Tkui\TclTk\Variable;
use Tkui\Tests\TestCase;
use Tkui\Widgets\PasswordEntry;
use Tkui\Windows\Window;

class PasswordEntryTest extends TestCase
{
    protected function createWindowStub(): Window
    {
        /** @var Window|Stub $win */
        $win = parent::createWindowStub();

        $var = $this->createStub(Variable::class);
        $var->method('__toString')->willReturn('var');
        $this->eval->method('registerVar')->willReturn($var);

        return $win;
    }

    public function test_password_entry_created_with_show_option(): void
    {
        $this->tclEvalTest(3, [
            ['ttk::entry', '.e1'],
            ['.e1', 'configure', '-textvariable', 'var'],
            ['.e1', 'configure', '-show', '*'],
        ]);

        new PasswordEntry($this->createWindowStub());
    }
}
