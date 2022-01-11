<?php declare(strict_types=1);

namespace Tkui\Tests\Widgets;

use Tkui\TclTk\TkFont;
use PHPUnit\Framework\MockObject\Stub\Stub;
use Tkui\Tests\TestCase;
use Tkui\TclTk\Variable;
use Tkui\Widgets\Entry;
use Tkui\Widgets\Widget;

class EntryTest extends TestCase
{
    protected function createWindowStub(): Widget
    {
        /** @var Widget|Stub $win */
        $win = parent::createWindowStub();

        $var = $this->createStub(Variable::class);
        $var->method('__toString')->willReturn('var');
        $this->eval->method('registerVar')->willReturn($var);

        return $win;
    }

    /** @test */
    public function entry_created()
    {
        $this->tclEvalTest(2, [
            ['ttk::entry', '.e1'],
            ['.e1', 'configure', '-textvariable', 'var'],
        ]);

        new Entry($this->createWindowStub());
    }

    /** @test */
    public function entry_with_predefined_value()
    {
        $this->tclEvalTest(2, [
            ['ttk::entry', $this->checkWidget('.e')],
            [$this->checkWidget('.e'), 'configure', '-textvariable', 'var'],
        ]);

        new Entry($this->createWindowStub(), 'Some text');
    }

    /** @test */
    public function entry_get_value()
    {
        $this->tclEvalTest(2, [
            ['ttk::entry', $this->checkWidget('.e')],
            [$this->checkWidget('.e'), 'configure', '-textvariable', 'var']
        ]);

        (new Entry($this->createWindowStub()))->getValue();
    }

    /** @test */
    public function clear_value()
    {
        $this->tclEvalTest(2, [
            ['ttk::entry', $this->checkWidget('.e')],
            [$this->checkWidget('.e'), 'configure', '-textvariable', 'var'],
        ]);

        $varMock = $this->createMock(Variable::class);
        $varMock->expects($this->exactly(2))
            ->method('set')
            ->withConsecutive(['initial value'], ['']);
        $varMock->method('__toString')->willReturn('var');
        $this->eval->method('registerVar')->willReturn($varMock);

        (new Entry($this->createWindowStub(), 'initial value'))->clear();
    }

    /** @test */
    public function insert_value()
    {
        $this->tclEvalTest(3, [
            ['ttk::entry', $this->checkWidget('.e')],
            [$this->checkWidget('.e'), 'configure', '-textvariable', 'var'],
            [$this->checkWidget('.e'), 'insert', '10', '{Test}']
        ]);

        (new Entry($this->createWindowStub()))->insert(10, 'Test');
    }

    /** @test */
    public function delete_one_char()
    {
        $this->tclEvalTest(3, [
            ['ttk::entry', $this->checkWidget('.e')],
            [$this->checkWidget('.e'), 'configure', '-textvariable', 'var'],
            [$this->checkWidget('.e'), 'delete', '5']
        ]);

        (new Entry($this->createWindowStub()))->delete(5);
    }

    /** @test */
    public function delete_a_range_of_chars()
    {
        $this->tclEvalTest(3, [
            ['ttk::entry', $this->checkWidget('.e')],
            [$this->checkWidget('.e'), 'configure', '-textvariable', 'var'],
            [$this->checkWidget('.e'), 'delete', '5', '10']
        ]);

        (new Entry($this->createWindowStub()))->delete(5, 10);
    }

    /** @test */
    public function set_font_as_property()
    {
        $this->tclEvalTest(3, [
            ['ttk::entry', $this->checkWidget('.e')],
            [$this->checkWidget('.e'), 'configure', '-textvariable', 'var'],
            [$this->checkWidget('.e'), 'configure', '-font', '{{Foo Font} 14 normal bold}'],
        ]);

        $e = new Entry($this->createWindowStub());
        $e->font = new TkFont('Foo Font', 14, TkFont::BOLD);
    }

    /** @test */
    public function create_entry_with_font_as_option()
    {
        $this->tclEvalTest(2, [
            ['ttk::entry', $this->checkWidget('.e'), '-font', '{{Foo Font} 14 normal bold}'],
            [$this->checkWidget('.e'), 'configure', '-textvariable', 'var'],
        ]);

        new Entry($this->createWindowStub(), '', [
            'font' => new TkFont('Foo Font', 14, TkFont::BOLD),
        ]);
    }
}