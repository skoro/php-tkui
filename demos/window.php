<?php

use Tkui\Widgets\Buttons\Button;
use Tkui\Windows\ChildWindow;
use Tkui\Windows\Window;

require_once dirname(__FILE__) . '/DemoAppWindow.php';

$demo = new class extends DemoAppWindow
{
    public function __construct()
    {
        parent::__construct('Window demo');

        $b1 = new Button($this, 'Fullscreen window');
        $b1->onClick(function () {
            $this->newWindow('Fullscreen')
                    ->getWindowManager()
                    ->setFullScreen();
        });
        $this->pack($b1);

        $b2 = new Button($this, 'Iconify');
        $b2->onClick(function () {
                $this->getWindowManager()->iconify();
        });
        $this->pack($b2);

        $b3 = new Button($this, 'Max and min size');
        $b3->onClick(function () {
            $this->newWindow('MaxSize')
                    ->getWindowManager()
                    ->setMaxSize(200, 200)
                    ->setMinSize(100, 40);
        });
        $this->pack($b3);

        $b4 = new Button($this, 'Window at 0,0');
        $b4->onClick(function () {
            $this->newWindow('(0,0)')
                    ->getWindowManager()
                    ->setPos(0, 0);
        });
        $this->pack($b4);

        $b5 = new Button($this, 'No decorate');
        $b5->onClick(function () {
            $this->newWindow('No decorate by Window Manager')
                 ->getWindowManager()
                 ->setOverrideRedirect(true)
                 ->setMinSize(260, 320)
                 ->setPos(400, 300)
                 ;
        });
        $this->pack($b5);

        $b6 = new Button($this, 'Show modal');
        $b6->onClick(function () {
            $win = $this->newWindow('Modal window');
            $win->getWindowManager()->setSize(260, 220);
            $win->showModal();
        });
        $this->pack($b6);

        $this->getWindowManager()->setMinSize(200, 200);
    }

    public function newWindow(string $title): Window
    {
        $w = new ChildWindow($this, $title);
        $btn = new Button($w, 'Close');
        $btn->onClick([$w, 'close']);
        $this->pack($btn);
        return $w;
    }

    public function run(): void
    {
        $this->app->run();
    }
};

$demo->run();
