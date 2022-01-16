<?php declare(strict_types=1);

namespace Tkui\Tests\Widgets;

use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use Tkui\Tests\TestCase;
use Tkui\Widgets\Listbox;
use Tkui\Widgets\ListboxItem;
use Tkui\Widgets\Scrollbar;

class ListboxTest extends TestCase
{
    /** @test */
    public function listbox_created()
    {
        $this->tclEvalTest(1, [['listbox', $this->checkWidget('.lb')]]);

        new Listbox($this->createWindowStub());
    }

    /** @test */
    public function listbox_init_with_items()
    {
        $this->tclEvalTest(3, [
            ['listbox', $this->checkWidget('.lb')],
            [$this->checkWidget('.lb'), 'insert', 'end', '{Test 1}'],
            [$this->checkWidget('.lb'), 'insert', 'end', '{Test 2}']
        ]);

        new Listbox($this->createWindowStub(), [
            new ListboxItem('Test 1'),
            new ListboxItem('Test 2'),
        ]);
    }

    /** @test */
    public function active_item()
    {
        $this->tclEvalTest(2, [
            ['listbox', $this->checkWidget('.lb')],
            [$this->checkWidget('.lb'), 'activate', '1'],
        ]);

        (new Listbox($this->createWindowStub()))->activate(1);
    }

    /** @test */
    public function delete_with_only_first()
    {
        $this->tclEvalTest(5, [
            ['listbox', $this->checkWidget('.lb')],
            [$this->checkWidget('.lb'), 'insert', 'end', '{100}'],
            [$this->checkWidget('.lb'), 'insert', 'end', '{101}'],
            [$this->checkWidget('.lb'), 'insert', 'end', '{102}'],
            [$this->checkWidget('.lb'), 'delete', '2'],
        ]);

        $lb = new Listbox($this->createWindowStub(), [
            new ListboxItem('100'),
            new ListboxItem('101'),
            new ListboxItem('102'),
        ]);
        $lb->delete(2);

        $this->assertEquals(2, $lb->size());
    }

    /** @test */
    public function delete_with_first_and_last()
    {
        $this->tclEvalTest(5, [
            ['listbox', $this->checkWidget('.lb')],
            [$this->checkWidget('.lb'), 'insert', 'end', '{100}'],
            [$this->checkWidget('.lb'), 'insert', 'end', '{101}'],
            [$this->checkWidget('.lb'), 'insert', 'end', '{102}'],
            [$this->checkWidget('.lb'), 'delete', '0', '2'],
        ]);

        $lb = new Listbox($this->createWindowStub(), [
            new ListboxItem('100'),
            new ListboxItem('101'),
            new ListboxItem('102'),
        ]);
        $lb->delete(0, 2);

        $this->assertEquals(0, $lb->size());
    }

    /** @test */
    public function delete_first_cannot_be_less_than_zero()
    {
        $this->tclEvalTest(2, [
            ['listbox', $this->checkWidget('.lb')],
            [$this->checkWidget('.lb'), 'insert', 'end', '{100}'],
        ]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Index is out of range.');

        (new Listbox($this->createWindowStub(), [
            new ListboxItem('100'),
        ]))->delete(-1);
    }

    /** @test */
    public function delete_first_cannot_be_more_than_max_items()
    {
        $this->tclEvalTest(2, [
            ['listbox', $this->checkWidget('.lb')],
            [$this->checkWidget('.lb'), 'insert', 'end', '{100}'],
        ]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Index is out of range.');

        (new Listbox($this->createWindowStub(), [
            new ListboxItem('100'),
        ]))->delete(5);
    }

    /** @test */
    public function get_items_only_first()
    {
        $first = (new Listbox($this->createWindowStub(), [
            new ListboxItem('aaa'),
            new ListboxItem('bbb'),
        ]))->get(1);

        $this->assertCount(1, $first);
        $this->assertEquals('bbb', $first[0]->value());
    }

    /** @test */
    public function get_items_with_range()
    {
        $range = (new Listbox($this->createWindowStub(), [
            new ListboxItem('aaa'),
            new ListboxItem('bbb'),
            new ListboxItem('ccc'),
            new ListboxItem('ddd'),
        ]))->get(1, 2);

        $this->assertCount(2, $range);
        $this->assertEquals('bbb', $range[0]->value());
        $this->assertEquals('ccc', $range[1]->value());
    }

    /** @test */
    public function get_items_validate_range()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Index is out of range.');

        (new Listbox($this->createWindowStub(), [
            new ListboxItem('aaa'),
            new ListboxItem('bbb'),
            new ListboxItem('ccc'),
            new ListboxItem('ddd'),
        ]))->get(1, 4);
    }

    /** @test */
    public function see_item()
    {
        $this->tclEvalTest(4, [
            ['listbox', $this->checkWidget('.lb')],
            [$this->checkWidget('.lb'), 'insert', 'end', '{aaa}'],
            [$this->checkWidget('.lb'), 'insert', 'end', '{bbb}'],
            [$this->checkWidget('.lb'), 'see', '1']
        ]);

        (new Listbox($this->createWindowStub(), [
            new ListboxItem('aaa'),
            new ListboxItem('bbb'),
        ]))->see(1);
    }

    /** @test */
    public function insert_items()
    {
        $this->tclEvalTest(3, [
            ['listbox', $this->checkWidget('.lb')],
            [$this->checkWidget('.lb'), 'insert', 'end', '{aaa}'],
            [$this->checkWidget('.lb'), 'insert', '0', '{bbb}'],
        ]);

        $lb = new Listbox($this->createWindowStub(), [new ListboxItem('aaa')]);
        $lb->insert(0, new ListboxItem('bbb'));

        $items = $lb->items();
        $this->assertCount(2, $items);
        $this->assertEquals('bbb', $items[0]->value());
        $this->assertEquals('aaa', $items[1]->value());
    }

    /** @test */
    public function append_item()
    {
        $this->tclEvalTest(3, [
            ['listbox', $this->checkWidget('.lb')],
            [$this->checkWidget('.lb'), 'insert', 'end', '{aaa}'],
            [$this->checkWidget('.lb'), 'insert', 'end', '{bbb}'],
        ]);

        $lb = new Listbox($this->createWindowStub());
        $lb->append(new ListboxItem('aaa'));
        $lb->append(new ListboxItem('bbb'));

        $this->assertCount(2, $lb->items());
        $this->assertEquals('aaa', $lb->items()[0]->value());
        $this->assertEquals('bbb', $lb->items()[1]->value());
    }

    /** @test */
    public function clear_items()
    {
        $this->tclEvalTest(4, [
            ['listbox', $this->checkWidget('.lb')],
            [$this->checkWidget('.lb'), 'insert', 'end', '{aaa}'],
            [$this->checkWidget('.lb'), 'insert', 'end', '{bbb}'],
            [$this->checkWidget('.lb'), 'delete', '0', '1'],
        ]);

        $lb = new Listbox($this->createWindowStub(), [
            new ListboxItem('aaa'),
            new ListboxItem('bbb'),
        ]);

        $this->assertCount(2, $lb->items());

        $lb->clear();

        $this->assertCount(0, $lb->items());
    }

    /** @test */
    public function select_items()
    {
        $this->tclEvalTest(4, [
            ['listbox', $this->checkWidget('.lb')],
            [$this->checkWidget('.lb'), 'insert', 'end', '{aaa}'],
            [$this->checkWidget('.lb'), 'insert', 'end', '{bbb}'],
            [$this->checkWidget('.lb'), 'selection', 'set', '0', '1'],
        ]);

        $lb = new Listbox($this->createWindowStub(), [
            new ListboxItem('aaa'),
            new ListboxItem('bbb'),
        ]);
        $lb->select(0, 1);
    }

    /** @test */
    public function unselect_items()
    {
        $this->tclEvalTest(4, [
            ['listbox', $this->checkWidget('.lb')],
            [$this->checkWidget('.lb'), 'insert', 'end', '{aaa}'],
            [$this->checkWidget('.lb'), 'insert', 'end', '{bbb}'],
            [$this->checkWidget('.lb'), 'selection', 'clear', '0', '1'],
        ]);

        $lb = new Listbox($this->createWindowStub(), [
            new ListboxItem('aaa'),
            new ListboxItem('bbb'),
        ]);
        $lb->unselect(0, 1);
    }

    /** @test */
    public function vert_and_horiz_scrollbars()
    {
        $lb = new Listbox($this->createWindowStub());

        /** @var Scrollbar|MockObject */
        $scr = $this->createMock(Scrollbar::class);
        $scr->expects($this->exactly(2))
            ->method('__set')
            ->with('command', $lb)
            ;
        $lb->xScrollCommand = $scr;
        $lb->yScrollCommand = $scr;
    }
}