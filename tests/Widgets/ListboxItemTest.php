<?php declare(strict_types=1);

namespace Tkui\Tests\Widgets;

use PHPUnit\Framework\MockObject\MockObject;
use Tkui\Tests\TestCase;
use Tkui\Widgets\Listbox;
use Tkui\Widgets\ListboxItem;

class ListboxItemTest extends TestCase
{
    /** @test */
    public function setting_value()
    {
        $li = new ListboxItem('test');
        $this->assertEquals('test', $li->value());
    }

    /** @test */
    public function item_attached_to_listbox_constructor()
    {
        /** @var ListboxItem|MockObject $item */
        $item = $this->createMock(ListboxItem::class);
        $item->expects($this->once())
             ->method('attach')
             ;
        (new Listbox($this->createWindowStub(), array($item)));
    }

    /** @test */
    public function item_attached_in_append()
    {
        /** @var ListboxItem|MockObject $item */
        $item = $this->createMock(ListboxItem::class);
        $item->expects($this->once())
             ->method('attach')
             ;
        (new Listbox($this->createWindowStub()))->append($item);
    }

    /** @test */
    public function item_attached_in_insert()
    {
        $item0 = new ListboxItem('zero');

        /** @var ListboxItem|MockObject $item */
        $item = $this->createMock(ListboxItem::class);
        $item->expects($this->once())
             ->method('attach')
             ;
        (new Listbox($this->createWindowStub(), array($item0)))->insert(0, $item);
    }

    /** @test */
    public function item_detached_when_deleted()
    {
        /** @var ListboxItem|MockObject $item */
        $item = $this->createMock(ListboxItem::class);
        $item->expects($this->once())
             ->method('detach')
             ;
        (new Listbox($this->createWindowStub(), array($item)))->delete(0);
    }

    /** @test */
    public function update_listbox_when_item_option_is_changed()
    {
        $this->tclEvalTest(3, [
            ['listbox', $this->checkWidget('.lb')],
            [$this->checkWidget('.lb'), 'insert', 'end', '{test}'],
            [$this->checkWidget('.lb'), 'itemconfigure', '0', '-background', 'red'],
        ]);

        $item = new ListboxItem('test');
        $listbox = new Listbox($this->createWindowStub());
        $listbox->append($item);
        $item->background = 'red';
    }
}