<?php declare(strict_types=1);

namespace TclTk\Tests\Widgets;

use PHPUnit\Framework\MockObject\Stub\Stub;
use TclTk\Tests\TestCase;
use TclTk\Variable;
use TclTk\Widgets\Entry;
use TclTk\Widgets\Widget;

class EntryTest extends TestCase
{
    protected function createWindowStub(): Widget
    {
        /** @var Widget|Stub $win */
        $win = parent::createWindowStub();

        $var = $this->createStub(Variable::class);
        $var->method('__toString')->willReturn('var');

        $win->method('registerVar')->willReturn($var);

        return $win;
    }

    /** @test */
    public function entry_created()
    {
        $this->tclEvalTest(2, [
            ['entry', '.e1'],
            ['.e1', 'configure', '-textvariable', 'var'],
        ]);

        new Entry($this->createWindowStub());
    }

    /** @test */
    public function entry_with_predefined_value()
    {
        $this->tclEvalTest(2, [
            ['entry', $this->checkWidget('.e')],
            [$this->checkWidget('.e'), 'configure', '-textvariable', 'var'],
        ]);

        new Entry($this->createWindowStub(), 'Some text');
    }

    /** @test */
    public function entry_get_value()
    {
        $this->tclEvalTest(2, [
            ['entry', $this->checkWidget('.e')],
            [$this->checkWidget('.e'), 'configure', '-textvariable', 'var']
        ]);

        (new Entry($this->createWindowStub()))->getValue();
    }

    /** @test */
    public function clear_value()
    {
        $this->tclEvalTest(2, [
            ['entry', $this->checkWidget('.e')],
            [$this->checkWidget('.e'), 'configure', '-textvariable', 'var'],
        ]);

        $varMock = $this->createMock(Variable::class);
        $varMock->expects($this->exactly(2))
            ->method('set')
            ->withConsecutive(['initial value'], ['']);
        $varMock->method('__toString')->willReturn('var');
        $win = parent::createWindowStub();
        $win->method('registerVar')->willReturn($varMock);

        (new Entry($win, 'initial value'))->clear();
    }

    /** @test */
    public function insert_value()
    {
        $this->tclEvalTest(3, [
            ['entry', $this->checkWidget('.e')],
            [$this->checkWidget('.e'), 'configure', '-textvariable', 'var'],
            [$this->checkWidget('.e'), 'insert', '10', '{Test}']
        ]);

        (new Entry($this->createWindowStub()))->insert(10, 'Test');
    }

    /** @test */
    public function delete_one_char()
    {
        $this->tclEvalTest(3, [
            ['entry', $this->checkWidget('.e')],
            [$this->checkWidget('.e'), 'configure', '-textvariable', 'var'],
            [$this->checkWidget('.e'), 'delete', '5']
        ]);

        (new Entry($this->createWindowStub()))->delete(5);
    }

    /** @test */
    public function delete_a_range_of_chars()
    {
        $this->tclEvalTest(3, [
            ['entry', $this->checkWidget('.e')],
            [$this->checkWidget('.e'), 'configure', '-textvariable', 'var'],
            [$this->checkWidget('.e'), 'delete', '5', '10']
        ]);

        (new Entry($this->createWindowStub()))->delete(5, 10);
    }
}