<?php

declare(strict_types=1);

namespace Tkui\Tests\Widgets;

use Tkui\Tests\TestCase;
use Tkui\Widgets\TreeView\Column;
use Tkui\Widgets\TreeView\Header;
use Tkui\Widgets\TreeView\Item;
use Tkui\Widgets\TreeView\TreeView;

class TreeViewTest extends TestCase
{
    /** @test */
    public function treeview_created(): void
    {
        $this->tclEvalTest(3, [
            ['ttk::treeview', $this->checkWidget('.tv'), '-columns', '{{c1} {c2}}', '-show', '{{headings}}'],
            [$this->checkWidget('.tv'), 'heading', 'c1', '-text', 'column1'],
            [$this->checkWidget('.tv'), 'heading', 'c2', '-text', 'column2'],
        ]);

        new TreeView($this->createWindowStub(), [
            Column::create('c1', 'column1'),
            Column::create('c2', 'column2'),
        ]);
    }

    /** @test */
    public function treeview_can_add_item(): void
    {
        $item = new Item([1,2,3]);

        $this->tclEvalTest(3, [
            ['ttk::treeview', $this->checkWidget('.tv')],
            [$this->checkWidget('.tv'), 'heading'],
            [$this->checkWidget('.tv'), 'insert', '{}', 'end', '-id', $item->id, '-values', '{{1} {2} {3}}'],
        ]);

        $tv = new TreeView($this->createWindowStub(), [
            Column::create('c1', 'h1'),
        ]);
        $tv->add($item);
    }

    /** @test */
    public function treeview_item_can_be_deleted(): void
    {
        $item = new Item([1,2,3]);

        $this->tclEvalTest(4, [
            ['ttk::treeview', $this->checkWidget('.tv')],
            [$this->checkWidget('.tv'), 'heading'],
            [$this->checkWidget('.tv'), 'insert', '{}', 'end', '-id', $item->id],
            [$this->checkWidget('.tv'), 'delete', $item->id],
        ]);

        $tv = new TreeView($this->createWindowStub(), [
            Column::create('c1', 'h1'),
        ]);
        $tv->add($item);
        $tv->delete($item);
    }
}