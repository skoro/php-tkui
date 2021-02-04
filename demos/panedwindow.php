<?php

use TclTk\App;
use TclTk\Widgets\Label;
use TclTk\Widgets\PanedWindow;
use TclTk\Widgets\Window;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$demo = new class extends Window
{
    public function __construct()
    {
        parent::__construct(App::create(), 'Paned window demo');

        $pw = new PanedWindow($this, ['orient' => PanedWindow::ORIENT_HORIZONTAL]);
        $pw->pack()->expand()->fillBoth()->pad(2, 2)->manage();

        $pw->add(new Label($pw, "This is the left side."))
           ->add(new Label($pw, "This is the right side."));
    }
};

$demo->app()->mainLoop();
