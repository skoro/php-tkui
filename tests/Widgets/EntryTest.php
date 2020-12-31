<?php declare(strict_types=1);

namespace TclTk\Tests\Widgets;

use TclTk\Tests\TestCase;
use TclTk\Widgets\Entry;

class EntryTest extends TestCase
{
    /** @test */
    public function entry_created()
    {
        $this->tclEvalTest(1, [['entry', '.e1']]);

        new Entry($this->createWindowStub());
    }

    /** @test */
    public function entry_with_predefined_value()
    {
        $this->tclEvalTest(3, [
            ['entry', $this->checkWidget('.e')],
            [$this->checkWidget('.e'), 'delete', '0', 'end'],
            [$this->checkWidget('.e'), 'insert', '0', '{Some text}']
        ]);

        new Entry($this->createWindowStub(), 'Some text');
    }

    /** @test */
    public function entry_get_value()
    {
        $this->tclEvalTest(2, [
            ['entry', $this->checkWidget('.e')],
            [$this->checkWidget('.e'), 'get']
        ]);

        (new Entry($this->createWindowStub()))->get();
    }

    /** @test */
    public function clear_value()
    {
        $this->tclEvalTest(2, [
            ['entry', $this->checkWidget('.e')],
            [$this->checkWidget('.e'), 'delete', '0', 'end']
        ]);

        (new Entry($this->createWindowStub()))->clear();
    }

    /** @test */
    public function insert_value()
    {
        $this->tclEvalTest(2, [
            ['entry', $this->checkWidget('.e')],
            [$this->checkWidget('.e'), 'insert', '10', '{Test}']
        ]);

        (new Entry($this->createWindowStub()))->insert(10, 'Test');
    }

    /** @test */
    public function delete_one_char()
    {
        $this->tclEvalTest(2, [
            ['entry', $this->checkWidget('.e')],
            [$this->checkWidget('.e'), 'delete', '5']
        ]);

        (new Entry($this->createWindowStub()))->delete(5);
    }

    /** @test */
    public function delete_a_range_of_chars()
    {
        $this->tclEvalTest(2, [
            ['entry', $this->checkWidget('.e')],
            [$this->checkWidget('.e'), 'delete', '5', '10']
        ]);

        (new Entry($this->createWindowStub()))->delete(5, 10);
    }
}