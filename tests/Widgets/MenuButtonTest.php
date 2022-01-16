<?php declare(strict_types=1);

namespace Tkui\Tests\Widgets;

use Tkui\Tests\TestCase;
use Tkui\Widgets\Buttons\MenuButton;
use Tkui\Widgets\Menu\Menu;
use Tkui\Widgets\Menu\MenuItem;

class MenuButtonTest extends TestCase
{
    /** @test */
    public function menubutton_is_created()
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
}