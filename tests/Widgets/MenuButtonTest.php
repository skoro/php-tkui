<?php declare(strict_types=1);

namespace Tkui\Tests\Widgets;

use Tkui\Tests\TestCase;
use Tkui\Widgets\Buttons\MenuButton;
use Tkui\Widgets\Consts\Direction;
use Tkui\Widgets\Menu\Menu;
use Tkui\Widgets\Menu\MenuItem;

class MenuButtonTest extends TestCase
{
    /** @test */
    public function it_creates_menubutton_widget(): void
    {
        $this->tclEvalTest(3, [
            ['menu', $this->checkWidget('.m')],
            [$this->checkWidget('.m'), 'add', 'command', '-label', 'test'],
            ['ttk::menubutton', $this->checkWidget('.mbtn'), '-text', '{MenuButton}', '-menu', $this->checkWidget('.m')],
        ]);

        $w = $this->createWindowStub();

        $m = new Menu($w);
        $m->addItem(new MenuItem('test', null));

        new MenuButton($w, 'MenuButton', $m);
    }

    /** @test */
    public function it_creates_menubutton_with_direction(): void
    {
        $this->tclEvalTest(3, [
            ['menu', $this->checkWidget('.m')],
            [$this->checkWidget('.m'), 'add', 'command', '-label', 'test'],
            [
                'ttk::menubutton',
                $this->checkWidget('.mbtn'),
                '-text', '{MenuButton}',
                '-menu', $this->checkWidget('.m'),
                '-direction', 'right'
            ],
        ]);

        $w = $this->createWindowStub();

        $m = new Menu($w);
        $m->addItem(new MenuItem('test', null));

        new MenuButton($w, 'MenuButton', $m, [
            'direction' => Direction::RIGHT,
        ]);
    }
}