<?php

use TclTk\Widgets\Buttons\Button;
use TclTk\Windows\ChildWindow;
use TclTk\Windows\Window;

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
                $wm = $this->newWindow('MaxSize')->getWindowManager();
                $wm->setMaxSize(200, 200);
                $wm->setMinSize(100, 40);
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
