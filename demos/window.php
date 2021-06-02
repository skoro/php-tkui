<?php

use PhpGui\Widgets\Buttons\Button;
use PhpGui\Windows\ChildWindow;
use PhpGui\Windows\Window;

require_once dirname(__FILE__) . '/DemoAppWindow.php';

$demo = new class extends DemoAppWindow
{
    public function __construct()
    {
        parent::__construct('Window demo');

        (new Button($this, 'Fullscreen window'))
            ->onClick(function () {
                $this->newWindow('Fullscreen')
                     ->getWindowManager()
                     ->setFullScreen();
            })
            ->pack()->manage();

        (new Button($this, 'Iconify'))
            ->onClick(function () {
                $this->getWindowManager()->iconify();
            })
            ->pack()->manage();

        (new Button($this, 'Max and min size'))
            ->onClick(function () {
                $this->newWindow('MaxSize')
                     ->getWindowManager()
                     ->setMaxSize(200, 200)
                     ->setMinSize(100, 40);
            })
            ->pack()->manage();

        (new Button($this, 'Window at 0,0'))
            ->onClick(function () {
                $this->newWindow('(0,0)')
                     ->getWindowManager()
                     ->setPos(0, 0);
            })
            ->pack()->manage();

        $this->getWindowManager()->setMinSize(200, 200);
    }

    public function newWindow(string $title): Window
    {
        $w = new ChildWindow($this, $title);
        $btn = new Button($w, 'Close');
        $btn->pack()->manage();
        $btn->onClick([$w, 'close']);
        return $w;
    }

    public function run(): void
    {
        $this->app->run();
    }
};

$demo->run();
