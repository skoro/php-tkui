<?php declare(strict_types=1);

namespace Tkui\Tests\Widgets;

use Tkui\Tests\TestCase;
use Tkui\Widgets\Menu\Menu;
use Tkui\Widgets\Menu\MenuCheckItem;
use Tkui\Widgets\Menu\MenuItem;
use Tkui\Widgets\Menu\MenuRadioItem;

class MenuTest extends TestCase
{
    /** @test */
    public function menu_is_created()
    {
        $this->tclEvalTest(1, [
            ['menu', $this->checkWidget('.m')],
        ]);

        new Menu($this->createWindowStub());
    }

    /** @test */
    public function item_can_be_added()
    {
        $this->tclEvalTest(2, [
            ['menu', $this->checkWidget('.m')],
            [$this->checkWidget('.m'), 'add', 'command', '-label', 'Test 1'],
        ]);

        (new Menu($this->createWindowStub()))
            ->addItem(new MenuItem('Test 1', function () {}))
        ;
    }

    /** @test */
    public function item_with_underline()
    {
        $this->tclEvalTest(2, [
            ['menu', $this->checkWidget('.m')],
            // This test will be failed if it runs separately because of command and static id()
            [$this->checkWidget('.m'), 'add', 'command', '-label', 'Test 1', '-command', ' 3', '-underline', 5],
        ]);

        (new Menu($this->createWindowStub()))
            ->addItem(new MenuItem('Test _1', function () {}))
        ;
    }

    /** @test */
    public function checkbox_can_be_added()
    {
        $this->tclEvalTest(2, [
            ['menu', $this->checkWidget('.m')],
            [$this->checkWidget('.m'), 'add', 'checkbutton', '-label', 'Test 1'],
        ]);

        (new Menu($this->createWindowStub()))
            ->addItem(new MenuCheckItem('Test 1', true, function () {}))
        ;
    }

    /** @test */
    public function radio_can_be_added()
    {
        $this->tclEvalTest(2, [
            ['menu', $this->checkWidget('.m')],
            [$this->checkWidget('.m'), 'add', 'radiobutton', '-label', 'Test 1'],
        ]);

        (new Menu($this->createWindowStub()))
            ->addItem(new MenuRadioItem('Test 1', '1', function () {}))
        ;
    }

    /** @test */
    public function separator_can_be_added()
    {
        $this->tclEvalTest(2, [
            ['menu', $this->checkWidget('.m')],
            [$this->checkWidget('.m'), 'add', 'separator'],
        ]);

        (new Menu($this->createWindowStub()))
            ->addSeparator()
        ;
    }

    /** @test */
    public function submenu_can_be_added()
    {
        $this->tclEvalTest(3, [
            ['menu', $this->checkWidget('.m')],
            ['menu', $this->checkWidget('.m'), '-title', 'Submenu', '-tearoff', 0],
            [$this->checkWidget('.m'), 'add', 'cascade', '-label', 'Submenu'],
        ]);

        (new Menu($this->createWindowStub()))
            ->addMenu('Submenu')
        ;
    }

    /** @test */
    public function submenu_with_underline()
    {
        $this->tclEvalTest(3, [
            ['menu', $this->checkWidget('.m')],
            ['menu', $this->checkWidget('.m'), '-title', 'Submenu', '-tearoff', 0],
            [$this->checkWidget('.m'), 'add', 'cascade', '-label', 'Submenu', '-menu', $this->checkWidget('.m'), '-underline', 2],
        ]);

        (new Menu($this->createWindowStub()))
            ->addMenu('Su_bmenu')
        ;
    }
}