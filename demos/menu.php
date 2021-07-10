<?php

use PhpGui\Widgets\Menu\CommonItem;
use PhpGui\Widgets\Menu\Menu;
use PhpGui\Widgets\Menu\MenuCheckItem;
use PhpGui\Widgets\Menu\MenuItem;
use PhpGui\Widgets\Menu\MenuRadioGroup;
use PhpGui\Widgets\Menu\MenuRadioItem;
use PhpGui\Widgets\Scrollbar;
use PhpGui\Widgets\Text;

require_once dirname(__FILE__) . '/DemoAppWindow.php';

$demo = new class extends DemoAppWindow
{
    private Text $text;

    public function __construct()
    {
        parent::__construct('Menu demo');
        $this->appMenu();
        $this->text = $this->makeTextbox();
    }

    protected function appMenu()
    {
        $menu = new Menu($this);

        $itemCallback = [$this, 'logMenuItem'];

        $menu->addMenu('File')
             ->addItem(new MenuItem('New', $itemCallback))
             ->addSeparator()
             ->addItem(new MenuItem('Open', $itemCallback))
             ->addItem(new MenuItem('Save', $itemCallback))
             ->addItem(new MenuItem('Save As...', $itemCallback))
             ->addSeparator()
             ->addItem(new MenuItem('Quit', [$this->app, 'quit']))
            ;

        $checkCallback = [$this, 'logCheckItem'];
        $radioCallback = [$this, 'logRadioItem'];

        $menu->addMenu('Edit')
             ->addItem(new MenuItem('Find...', $itemCallback))
             ->addItem(new MenuItem('Replace...', $itemCallback))
             ->addSeparator()
             ->addItem(new MenuCheckItem('Wrap lines', true, $checkCallback))
             ->addItem(new MenuCheckItem('Show cursor pos', false, $checkCallback))
             ->addSeparator()
             ->addGroup(new MenuRadioGroup([
                new MenuRadioItem('Radio 1', 1),
                new MenuRadioItem('Radio 2', 2),
                new MenuRadioItem('Radio 3', 3)
             ], 2, $radioCallback))
             ;

        $this->setMenu($menu);
    }

    protected function makeTextbox(): Text
    {
        $yscr = new Scrollbar($this);
        $yscr->pack()->sideRight()->fillY()->manage();
        $txt = new Text($this);
        $txt->pack()->fillBoth()->expand()->manage();
        $txt->yScrollCommand = $yscr;
        return $txt;
    }

    public function logMenuItem(MenuItem $item)
    {
        $this->text->append("Menu item: {$item->label}\n");
    }

    public function logCheckItem(MenuCheckItem $item)
    {
        $value = $item->getValue() ? 'true' : 'false';
        $this->text->append("Check: {$item->label}, value: {$value}\n");
    }

    public function logRadioItem(MenuRadioItem $item)
    {
        $value = (string) $item->getValue();
        $this->text->append("Radio: {$item->label}, value: {$value}\n");
    }
};

$demo->run();
