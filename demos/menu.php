<?php

use PhpGui\Widgets\Menu;
use PhpGui\Widgets\Menu\MenuItem;

require_once dirname(__FILE__) . '/DemoAppWindow.php';

$demo = new class extends DemoAppWindow
{
    public function __construct()
    {
        parent::__construct('Menu demo');
        $this->appMenu();
    }

    protected function appMenu()
    {
        $menu = new Menu($this);

        $menu->addMenu('File')
             ->addItem(new MenuItem('New', function () {}))
            //  ->addSeparator()
             ->addItem(new MenuItem('Open', function () {}))
             ->addItem(new MenuItem('Save', function () {}))
             ->addItem(new MenuItem('Save As...'))
            //  ->addSeparator()
             ->addItem(new MenuItem('Quit'))
            ;

        $menu->addMenu('Edit')
             ->addItem(new MenuItem('Find...'))
             ->addItem(new MenuItem('Replace...'))
             ;

        $this->getEval()->tclEval($this->path(), 'configure', '-menu', $menu->path());
    }
};

$demo->run();
