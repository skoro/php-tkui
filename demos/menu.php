<?php

use PhpGui\Widgets\Menu\Menu;
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
             ->addItem(new MenuItem('Save As...', function () {}))
            //  ->addSeparator()
             ->addItem(new MenuItem('Quit', function () {
                 $this->app->quit();
             }))
            ;

        $menu->addMenu('Edit')
             ->addItem(new MenuItem('Find...', function () {}))
             ->addItem(new MenuItem('Replace...', function () {}))
             ;

        $this->getEval()->tclEval($this->path(), 'configure', '-menu', $menu->path());
    }
};

$demo->run();
